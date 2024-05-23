<!DOCTYPE html>
<html>
<head>
    <title>Make Account</title>
    <link rel="stylesheet" type="text/css" href="css/style10.css">
</head>
<body>
    <form action="register_check.php" method="post">
        <h2>Înregistrare</h2>
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>

        <div class="form-row">
            <div>
            

                <label>User Name*</label>
                <?php if (isset($_GET['uname'])) { ?>
                    <input type="text" 
                           name="uname" 
                           placeholder="User Name"
                           value="<?php echo $_GET['uname']; ?>"><br>
                <?php } else { ?>
                    <input type="text" 
                           name="uname" 
                           placeholder="User Name"><br>
                <?php } ?>

                <label>Email*</label>
                <?php if (isset($_GET['email'])) { ?>
                    <input type="email" 
                           name="email" 
                           placeholder="Email"
                           value="<?php echo $_GET['email']; ?>"><br>
                <?php } else { ?>
                    <input type="email" 
                           name="email" 
                           placeholder="Email"><br>
                <?php } ?>

                <label>Name</label>
                <?php if (isset($_GET['name'])) { ?>
                    <input type="text" 
                           name="name" 
                           placeholder="Name"
                           value="<?php echo $_GET['name']; ?>"><br>
                <?php } else { ?>
                    <input type="text" 
                           name="name" 
                           placeholder="Name"><br>
                <?php } ?>

                <label>Year</label>
                <?php if (isset($_GET['year'])) { ?>
                    <input type="text" 
                           name="year" 
                           placeholder="Year"
                           value="<?php echo $_GET['year']; ?>"><br>
                <?php } else { ?>
                    <input type="text" 
                           name="year" 
                           placeholder="Year"><br>
                <?php } ?>
            </div>

            <div>
                <label>Facultate</label>
                <?php if (isset($_GET['facultate'])) { ?>
                    <input type="text" 
                           name="facultate" 
                           placeholder="Facultate"
                           value="<?php echo $_GET['facultate']; ?>"><br>
                <?php } else { ?>
                    <input type="text" 
                           name="facultate" 
                           placeholder="Facultate"><br>
                <?php } ?>

                <label>Secția</label>
                <?php if (isset($_GET['sectia'])) { ?>
                    <input type="text" 
                           name="sectia" 
                           placeholder="Secția"
                           value="<?php echo $_GET['sectia']; ?>"><br>
                <?php } else { ?>
                    <input type="text" 
                           name="sectia" 
                           placeholder="Secția"><br>
                <?php } ?>

                <label>Tip învățământ</label>
                <?php if (isset($_GET['tip_invatamant'])) { ?>
                    <input type="text" 
                           name="tip_invatamant" 
                           placeholder="Tip învățământ"
                           value="<?php echo $_GET['tip_invatamant']; ?>"><br>
                <?php } else { ?>
                    <input type="text" 
                           name="tip_invatamant" 
                           placeholder="Tip învățământ"><br>
                <?php } ?>

                <label>Password*</label>
                <input type="password" 
                       name="password" 
                       placeholder="Password"><br>
            </div>
        </div> 

        <button type="submit">Trimite</button>
    </form>
</body>
</html>
