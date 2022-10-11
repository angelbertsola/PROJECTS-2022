<br />
   <nav class="navbar navbar-inverse">
    <div class="container-fluid">
     <div class="navbar-header">
      <a class="navbar-brand" href="index.php">SPACEBOOK</a>
     </div>
     <ul class="nav navbar-nav navbar-right">
      

       
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
        <?php
        echo Load_notification($connect, $_SESSION["user_id"]);

        ?>

        </ul>
       </a>
      </li>
      <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
       <span class="caret"></span></a>
       <ul class="dropdown-menu">
        <li><a href="profile.php">Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
       </ul>
      </li>
     </ul>
    </div>
   </nav>

   <script type="text/javascript">

    $(document).ready(function(){
     $('#search_user').typeahead({
      source:function(query, result)
      {
       $('.typeahead').css('position', 'absolute');
       $('.typeahead').css('top', '45px');
       var action = 'search_user';
       $.ajax({
        url:"action.php",
        method:"POST",
        data:{query:query, action:action},
        dataType:"json",
        success:function(data)
        {
         result($.map(data, function(item){
          return item;
         }));
        }
       })
      }
     });

     $(document).on('click', '.typeahead li', function(){
      var search_query = $(this).text();
      window.location.href="wall.php?data="+search_query;
     });
    });

   </script>