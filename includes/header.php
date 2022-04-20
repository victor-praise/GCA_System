          <nav class="navbar">
            <div class="systemName">
                GCA Portal
            </div>
            <div class="userName">
                <div class="user-details">
                    <i class="fa-solid fa-circle-user"></i>
                    <?= $_SESSION['username'] ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>
          
                <div class="dropdown__content">
                <p class="dropdown--item"> 
                    <a href="../change-password.php"><i class="fa-solid fa-key"></i> Change Password</a>
                 </p>
                 <?php if($_SESSION['role'] == 'student') : ?>
                        <p class="dropdown--item">
                     <a href="../student/messages.php"><i class="fa-solid fa-message"></i> Messages</a>
                    </p>
                        <p class="dropdown--item">
                     <a href="../student/course-select.php"><i class="fa-solid fa-repeat"></i>Change course</a>
                    </p>
                    <?php elseif($_SESSION['role'] == 'instructor') : ?>
                        <p class="dropdown--item">
                     <a href="../instructor/instructor.php"><i class="fa-solid fa-repeat"></i>Change course</a>
                    </p>
                    <?php else : ?>
                        <p class="dropdown--item">
                     <a href="../ta/course_select.php"><i class="fa-solid fa-repeat"></i>Change course</a>
                        <?php endif; ?>
                <p class="dropdown--item">
                     <a href="../logout.php"><i class="fa-solid fa-power-off"></i> Logout</a>
                    </p>
             
                </div>
            </div>
        </nav>