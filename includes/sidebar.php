<div class="side__container">
<aside class="sidebar">
        <?php if($_SESSION['role'] == 'admin') : ?>
        <!-- <div class="sidebar--links">  
            <a href="../admin/new_course.php">Set up Course</a>
        </div> -->
        <a href="../admin/index.php">
        <div class="sidebar--links">  
            Home
        </div>
        </a>
        <a href="../admin/courses.php">
        <div class="sidebar--links">  
            View Courses
        </div>
        </a>
       
       
        <?php elseif($_SESSION['role'] == 'ta') : ?>
        <div class="sidebar--links">
            ta Course
        </div>
        <?php elseif($_SESSION['role'] == 'instructor') : ?>
            <a href="../instructor/instructor_course.php?id=<?= $_SESSION['courseid'] ?>">
        <div class="sidebar--links">  
            Home
        </div>
        </a>
        <a href="../student/students.php?id=<?= $_SESSION['courseid'] ?>">
        <div class="sidebar--links">  
            Students
        </div>
        </a>
        <a href="../ta/ta.php?id=<?= $_SESSION['courseid'] ?>">
        <div class="sidebar--links">  
            Ta's
        </div>
        </a>
        <a href="../instructor/groups.php">
        <div class="sidebar--links">  
            Groups
        </div>
        </a>
        <a href="../instructor/">
        <div class="sidebar--links">  
        Assignment
        </div>
        </a>
        <!-- <div class="sidebar--links">
         Discussions
        </div>
        <div class="sidebar--links">
         Assignments
        </div> -->
        <?php else : ?>
        <div class="sidebar--links">
        Student Course
        </div>
        <?php endif; ?>
    </aside>
    <div class="content">  

            