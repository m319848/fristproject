/*
 * Include ethers v6 and this module on your activation page.
 * MetaMask uses window.ethereum.
 * WalletConnect uses @walletconnect/ethereum-provider (ES module).
 */
import { EthereumProvider } from "https://esm.sh/@walletconnect/ethereum-provider@2.21.1";
import { BrowserProvider, Contract, parseUnits } from "https://esm.sh/ethers@6.13.5";

const CHAIN_ID = 56;
const CHAIN_HEX = "0x38";
const USDT = "0x55d398326f99059fF775485246999027B3197955";
const VAULT = "PASTE_YOUR_DEPLOYED_VAULT_ADDRESS";
const PROJECT_ID = "PASTE_REOWN_WALLETCONNECT_PROJECT_ID";
const USDT_ABI = [
  "function allowance(address owner,address spender) view returns (uint256)",
  "function approve(address spender,uint256 value) returns (bool)"
];
const VAULT_ABI = ["function deposit(uint256 amount)"];

let provider = null;
let walletAddress = null;

const $ = (id) => document.getElementById(id);
function status(message) { $("walletStatus").textContent = message; }

async function connectMetaMask() {
  if (!window.ethereum) throw new Error("MetaMask not detected. Choose WalletConnect instead.");
  await window.ethereum.request({ method: "eth_requestAccounts" });
  try {
    await window.ethereum.request({ method: "wallet_switchEthereumChain", params: [{ chainId: CHAIN_HEX }] });
  } catch (e) {
    if (e.code === 4902) {
      await window.ethereum.request({ method: "wallet_addEthereumChain", params: [{
        chainId: CHAIN_HEX, chainName: "BNB Smart Chain",
        nativeCurrency: { name: "BNB", symbol: "BNB", decimals: 18 },
        rpcUrls: ["https://bsc-dataseed.binance.org/"],
        blockExplorerUrls: ["https://bscscan.com/"]
      }]});
    } else throw e;
  }
  provider = new BrowserProvider(window.ethereum);
  const signer = await provider.getSigner();
  walletAddress = await signer.getAddress();
  status("Connected: " + walletAddress);
  return signer;
}

async function connectWalletConnect() {
  const wc = await EthereumProvider.init({
    projectId: PROJECT_ID,
    chains: [CHAIN_ID],
    showQrModal: true,
    rpcMap: { [CHAIN_ID]: "https://bsc-dataseed.binance.org/" }
  });
  await wc.connect();
  provider = new BrowserProvider(wc);
  const signer = await provider.getSigner();
  walletAddress = await signer.getAddress();
  status("Connected: " + walletAddress);
  return signer;
}

$("connectMetaMask").addEventListener("click", async () => {
  try { await connectMetaMask(); } catch (e) { status(e.shortMessage || e.message); }
});
$("connectWalletConnect").addEventListener("click", async () => {
  try { await connectWalletConnect(); } catch (e) { status(e.shortMessage || e.message); }
});

$("depositForm").addEventListener("submit", async (event) => {
  event.preventDefault();
  const button = $("depositButton");
  try {
    if (!provider || !walletAddress) throw new Error("Please connect your wallet first.");
    if (!/^0x[a-fA-F0-9]{40}$/.test(VAULT)) throw new Error("Admin has not configured the deployed vault address.");
    const amountText = $("investAmount").value.trim();
    if (!/^[0-9]+$/.test(amountText)) throw new Error("Enter a whole-number USDT amount.");
    const amount = BigInt(amountText);
    if (amount < 50n || amount % 50n !== 0n) throw new Error("Minimum is 50 USDT, in multiples of 50.");

    button.disabled = true;
    const signer = await provider.getSigner();
    const token = new Contract(USDT, USDT_ABI, signer);
    const vault = new Contract(VAULT, VAULT_ABI, signer);
    const rawAmount = parseUnits(amountText, 18);

    status("Checking USDT allowance...");
    const allowance = await token.allowance(walletAddress, VAULT);
    if (allowance < rawAmount) {
      status("Please approve USDT in your wallet...");
      const approveTx = await token.approve(VAULT, rawAmount);
      await approveTx.wait();
    }

    status("Confirm the deposit transaction in your wallet...");
    const depositTx = await vault.deposit(rawAmount);
    status("Deposit submitted. Waiting for mining...");
    const receipt = await depositTx.wait(12);
    if (!receipt || receipt.status !== 1) throw new Error("Deposit transaction failed.");

    status("Deposit mined. PHP is verifying blockchain confirmations...");
    const body = new FormData();
    body.append("txHash", receipt.hash);
    body.append("walletAddress", walletAddress);
    const response = await fetch("authActiveUserProcess.php", {
      method: "POST", body, credentials: "same-origin"
    });
    const result = await response.json();
    if (!result.success) throw new Error(result.message || "Server verification failed.");
    status("Activated: " + result.amount + " USDT");
    alert(result.message + "\nAmount: " + result.amount + " USDT");
    window.location.href = "authActiveUser.php";
  } catch (e) {
    status(e.shortMessage || e.message || "Transaction failed.");
    alert(e.shortMessage || e.message || "Transaction failed.");
  } finally {
    button.disabled = false;
  }
});
