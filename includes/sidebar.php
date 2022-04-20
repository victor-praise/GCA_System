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
        <!-- <a href="../admin/discussion.php">
        <div class="sidebar--links">  
            Discussions
        </div>
        </a> -->
        <a href="../admin/announcement.php">
        <div class="sidebar--links">  
            Announcements
        </div>
        </a>
       
       
        <?php elseif($_SESSION['role'] == 'ta') : ?>
            <a href="../ta/ta_course.php?id=<?= $_SESSION['courseid'] ?>">
        <div class="sidebar--links">  
            Home
        </div>
        </a>   
         <a href="../ta/ta_markedEntity.php">
        <div class="sidebar--links">  
            Entity submissions
        </div>
        </a>
        <a href="../announcement.php">
        <div class="sidebar--links">  
            Announcements
        </div>
        </a>
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
        <a href="../instructor/markedentity.php">
        <div class="sidebar--links">  
        Marked entities
        </div>
        </a>
        <a href="../instructor/polls.php">
        <div class="sidebar--links">  
            Polls
        </div>
        </a>
        <a href="../announcement.php">
        <div class="sidebar--links">  
            Announcements
        </div>
        </a>
        <!-- <div class="sidebar--links">
         Discussions
        </div>
        <div class="sidebar--links">
         Assignments
        </div> -->
        <?php else : ?>
            <a href="../student/student_course.php?id=<?= $_SESSION['courseid'] ?>">
        <div class="sidebar--links">  
            Home
        </div>
        </a>
            <!-- <a href="../student/student_course.php?id=<?= $_SESSION['courseid'] ?>">
        <div class="sidebar--links">  
            Submissions
        </div>
        </a> -->
        <a href="../student/markedentity.php">
        <div class="sidebar--links">  
            Marked entities
        </div>
        </a>
        <a href="../student/student_poll.php">
        <div class="sidebar--links">  
            Polls
        </div>
        </a>
        <a href="../announcement.php">
        <div class="sidebar--links">  
            Announcements
        </div>
        </a>
        <?php endif; ?>
    </aside>
    <div class="content">  

            