<nav class="mobile-bottom-nav">
    <a href="Dashboard" class="mobile-nav__item mobile-nav__item--active">
        <i class="fa-solid fa-house"></i>
        <span class="mobile-nav__label">Home</span>
    </a>
    <a href="authActiveUser" class="mobile-nav__item">
        <i class="fi fi-rr-power"></i>
        <span class="mobile-nav__label">Activation</span>
    </a>
    <a href="walletWithdraw" class="mobile-nav__item">
        <i class="fa-solid fa-repeat"></i>
        <span class="mobile-nav__label">Withdrawal</span>
    </a>
    <!-- <a href="#" class="mobile-nav__item">
        <i class="fa-solid fa-magnifying-glass"></i>
        <span class="mobile-nav__label">Search</span>
    </a> -->
    <a href="authSignDash" class="mobile-nav__item">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span class="mobile-nav__label">Logout</span>
    </a>
</nav>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="assets/js/script.js"></script>
<script src="custom.js"></script>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            columnDefs: [
                { className: "center", targets: [0, 3] },
                { className: "right", targets: [4] }
            ],
            pageLength: 5
        });
    });
    $(document).ready(function () {
        $('#example1').DataTable({
            columnDefs: [
                { className: "center", targets: [0, 3] },
                { className: "right", targets: [4] }
            ],
            pageLength: 5
        });
    });
</script>
</body>

</html>