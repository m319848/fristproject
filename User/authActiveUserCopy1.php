<!-- Replace the old fund-wallet purchase form with this block.
     Keep your existing PHP header/sidebar/layout around it. -->
<div class="card">
  <h3>USDT Package Activation</h3>
  <p>Network: BNB Smart Chain (BSC) · Token: USDT</p>
  <button type="button" id="connectMetaMask">Connect MetaMask</button>
  <button type="button" id="connectWalletConnect">Connect WalletConnect / Trust Wallet</button>
  <p id="walletStatus">Wallet not connected</p>

  <form id="depositForm">
    <label for="investAmount">Investment amount (USDT)</label>
    <input id="investAmount" name="investAmount" type="number" min="50" step="50"
           placeholder="Enter amount e.g. 50, 100, 150" required>
    <button id="depositButton" type="submit">Approve &amp; Deposit USDT</button>
  </form>
</div>

<!-- For production, bundle these imports with your build tool if your hosting/CSP blocks esm.sh. -->
<script type="module" src="deposit.js"></script>
