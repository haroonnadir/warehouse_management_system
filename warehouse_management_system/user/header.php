<?php require_once 'main.php' ?>
<div class="wrapper d-flex align-items-stretch">
    <?php require_once 'nav.php' ?>
    <!-- Page Content  -->
    <div id="content" class="p-4">
        <?php require_once 'left-side.php' ?>
        <!-- start: BASIC EXAMPLE -->
        <div class="section-title">
            <h2>ADMIN || DASHBOARD</h2>
        </div>
        <!-- end: SELECT BOXES -->

    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>

</html>

<style>
.row {
    margin: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: row;
}

.panel-body {
    padding: 15px;
}

.panel-white,
.partition-white {
    background-color: #ffffff;
    position: relative;
    color: #5b5b60;
    border: 2px solid rgba(0, 0, 0, 0.07);
}

.container-fullw {
    margin-left: -15px;
    margin-right: -15px;
    padding-left: 30px;
    padding-right: 30px;
    padding-top: 30px;
    padding-bottom: 30px;
    border-bottom: 1px solid #eee;
}

@media (max-width: 768px) {
    .container-fullw {
        padding-left: 15px;
        padding-right: 15px;
    }
}
</style>