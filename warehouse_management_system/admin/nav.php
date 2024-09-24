<nav id="sidebar">
    <div class="p-4">
        <a href="#" class="img logo rounded-circle mb-5" style="background-image: url(images/img.png);"></a>
        <ul class="list-unstyled components mb-5">
            <li>
                <a style="text-align: center; margin-top:-30px"><?php echo $_SESSION['name'];  ?></a>
            </li>
            <li class="">
                <a href="header.php">Dashboard</a>
            </li>
            <li>
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">MEMBERS</a>
                <ul class="collapse list-unstyled" id="pageSubmenu">
                    <li>
                        <a href="add-members.php">Add Member</a>
                    </li>
                    <li>
                        <a href="manage-members.php">Manage Members</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#proSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Product</a>
                <ul class="collapse list-unstyled" id="proSubmenu">
                    <li>
                        <a href="add-product.php">Add Product</a>
                    </li>
                    <li>
                        <a href="manage-product.php">Manage Product</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#whSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">WareHouse
                    City</a>
                <ul class="collapse list-unstyled" id="whSubmenu">
                    <li>
                        <a href="add-whcity.php">Add WH CITY</a>
                    </li>
                    <li>
                        <a href="manage-whcity.php">Manage WH City</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#pwhSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Product in WH
                    City</a>
                <ul class="collapse list-unstyled" id="pwhSubmenu">
                    <li>
                        <a href="add-productwhcity.php">Add Product WH</a>
                    </li>
                    <li>
                        <a href="manage-productwhcity.php">Manage Prodcut WH</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#inSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Inventry
                </a>
                <ul class="collapse list-unstyled" id="inSubmenu">
                    <li>
                        <a href="add-inventry.php">Add Inventry</a>
                    </li>
                    <li>
                        <a href="manage-inventry.php">Manage Inventry</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#chSubmenu" data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle">Charts Account</a>
                <ul class="collapse list-unstyled" id="chSubmenu">
                    <li>
                        <a href="add-charts-account.php">Add Charts Account</a>
                    </li>
                    <li>
                        <a href="manage-charts-account.php">Manage Charts Account</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#trSubmenu" data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle">Transection</a>
                <ul class="collapse list-unstyled" id="trSubmenu">
                    <li>
                        <a href="add-transection.php">Add Transection</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#rpSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Reprts</a>
                <ul class="collapse list-unstyled" id="rpSubmenu">
                    <li>
                        <a href="reports.php">Reports</a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="footer pt-5">
            <p>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;<script>
                document.write(new Date().getFullYear());
                </script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i>
                by <a href="" target="_blank">STUDENTS</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
        </div>

    </div>
</nav>