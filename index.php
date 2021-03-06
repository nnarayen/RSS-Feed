<!DOCTYPE html>
<html lang="en">
  <head>
  	<script type="text/javascript" src="jquery.js"></script>
  	<script type="text/javascript" src="feed_api.js"></script>
  	<script type="text/javascript">
  	
  		google.load('feeds','1');
  		var currentPage = 'techcrunch';
  		
  		$('#techcrunch').live('click',function() {
  			loadDifferentPage('http://feeds.feedburner.com/TechCrunch/', 'techcrunch');
  		});
  		
  		$('#startups').live('click',function() {
  			loadDifferentPage('http://feeds.feedburner.com/TechCrunch/startups', 'startups');
  		});
  		
  		$('#fundings').live('click',function() {
  			loadDifferentPage('http://feeds.feedburner.com/TechCrunch/fundings-exits', 'fundings');
  		});
  		
  		$('#social').live('click',function() {
  			loadDifferentPage('http://feeds.feedburner.com/TechCrunch/social', 'social');
  		});
  		
  		$('#mobile').live('click',function() {
  			loadDifferentPage('http://feeds.feedburner.com/Mobilecrunch', 'mobile');
  		});
  		
  		$('#gadgets').live('click',function() {
  			loadDifferentPage('http://feeds.feedburner.com/crunchgear', 'gadgets');
  		});
  		
  		$('#gaming').live('click',function() {
  			loadDifferentPage('http://feeds.feedburner.com/TechCrunch/gaming', 'gaming');
  		});
  		
  		$('#enterprise').live('click',function() {
  			loadDifferentPage('http://feeds.feedburner.com/TechCrunchIT', 'enterprise');
  		});
  		
  		$('.post').live('click',function() {
  			$('#display_all_posts').css('display','none');
  			$('#display_one_post').css('display','inline');
  			
  			var postDiv = document.getElementById('post_text');
  			var titleDiv = document.getElementById('title');
  			$(postDiv).empty();
  			$(titleDiv).empty();
  			$(titleDiv).append('<h3><u>' + $(this).attr('title') + '</u></h3>');
  			$(postDiv).append($(this).attr('content'));
  			
  			$('#comments').load('findcomments.php', {title: $(titleDiv).text()});
  			
  			window.scroll(0,0);
  		});
  		
  		$('#back').live('click',function() {
  			$('#display_one_post').css('display','none');
  			$('#display_all_posts').css('display','inline');
  			$('#comments').empty();
  			window.scroll(0,0);
  		});
  		
  		$('#go_home').live('click',function() {
  			$('#display_one_post').css('display','none');
  			$('#display_all_posts').css('display','inline');
  			$('#comments').empty();
  			window.scroll(0,0);
  		});
  		
  		$('#post_comment').live('click',function() {
  			var username = document.getElementById('username_info');
  			var comment = document.getElementById('comment_text');
  			
  			if (username.value.length == 0 || comment.value.length == 0) {
  				alert('Please fill out both forms to submit a comment!');
  				return;
  			}
  			
  			var commentBox = document.getElementById('comments');
  			var html_comment = '<strong><i>' + username.value + '</i></strong>: ' + comment.value;
  			
  			var currentTime = new Date();
     	    var minutes = currentTime.getMinutes();
     	    var str_minutes = minutes < 10 ? '0' + minutes : '' + minutes
     	    var hours = currentTime.getHours();
     	    var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
     	    var month = monthNames[currentTime.getUTCMonth()];
     	    var day = currentTime.getUTCDate();
     	    var extra = hours > 12 ? 'PM' : 'AM';
     	    hours%=12;
     	    var time_string = '(' + month + ' ' + day + ', ' + hours + ':' + str_minutes + ' ' + extra + ')';
     	  
  			$(commentBox).append(html_comment + ' ' + time_string);
  			$(commentBox).append('<hr style="border:none; border-top:1px #CCCCCC solid; height:1px" />');
  			
  			var comment_information = {title: $('#title').text(), user: username.value, time: time_string, comment: comment.value};
  			var posting = $.post('postcomment.php', comment_information);
  			posting.done(function(data) {
				console.log(data);
			});
  			
  			$(username).val('');
  			$(comment).val('');
  		});
  		
  		function initialize() {
  			var feed = new google.feeds.Feed('http://feeds.feedburner.com/TechCrunch/');
  			feed.setNumEntries(20);
  			feed.load(function(result) {
  				if (!result.error) {
  					createFeedList(result);
  				}
  			});
  		}
  		
  		function createFeedList(result) {
  			if (!result.error) {
  				var container = document.getElementById('feed');
  				for (var i = 0; i < result.feed.entries.length; i++) {
  					var entry = result.feed.entries[i];
  					var postDiv = document.createElement('div');
  					var imageDiv = document.createElement('div');
  					var textDiv = document.createElement('div');
  						
  					$(postDiv).attr('style', 'float:left; padding-bottom:10px; cursor:pointer; cursor:hand');
  					$(postDiv).addClass('post');
  					$(postDiv).attr('content', entry.content);
  					$(postDiv).attr('title', entry.title);
  					
  					$(imageDiv).attr('style', 'float:left; border-style:solid; border-width:2px; height=130px; width=130px');
  					$(textDiv).attr('style', 'float:left; padding-left:10px;');
  					
  					//grab image source	
  					var imageSrc = $(entry.content.substring(0, entry.content.indexOf('>') + 1)).attr('src');
  					var imageTag = '<img width="130px" height="130px" src="' + imageSrc + '"/>';
  						
  					var entryTitle = entry.title.length < 100 ? entry.title : entry.title.substring(0, 100) + '...';
  					$(imageDiv).append(imageTag);
  					$(textDiv).append('<h4>' + entryTitle + '</h4>');
  					$(textDiv).append(entry.contentSnippet + '</br>');
  						
  					simpleDate = entry.publishedDate.substring(0, entry.publishedDate.indexOf('2012') + 4);
  					$(textDiv).append('Published: ' + simpleDate);
  					$(postDiv).append(imageDiv);
  					$(postDiv).append(textDiv);
  					container.appendChild(postDiv);
  				}
  			}
  		}
  		
  		function loadDifferentPage(url, page) {
  			var container = document.getElementById('feed');
  			$(container).empty();
  			var feed = new google.feeds.Feed(url);
  			feed.setNumEntries(20);
  			feed.load(function(result) {
  				if (!result.error) {
  					createFeedList(result);
  				}
  			});
  			$('#' + currentPage).removeClass('active');
  			$('#' + page).addClass('active');
  			currentPage = page;
  		}
  		
  		google.setOnLoadCallback(initialize);

    </script>
    <meta charset="utf-8">
    <title>Techcrunch Web App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a id="go_home" class="brand" href="#">Pulse App</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="#myContactModal" data-toggle="modal">Contact</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    <div class="container">

      <h1>Techcrunch RSS Feed</h1>
      <p>Use this website to read through your favorite Techcrunch Feeds!</p>
      
      </br>
      
      <div id="display_all_posts" style="display:inline">
      
      	<ul class="nav nav-tabs">
 	 	  <li class="active" id="techcrunch">
 	 	    <a href="#">Techcrunch</a>
 	 	  </li>
        <li id="startups"><a href="#">Startups</a></li>
        <li id="fundings"><a href="#">Fundings and Exits</a></li>
        <li id="social"><a href="#">Social</a></li>
        <li id="mobile"><a href="#">Mobile / Mobilecrunch</a></li>
        <li id="gadgets"><a href="#">Gadgets / Crunchgear</a></li>
        <li id="gaming"><a href="#">Gaming</a></li>
        <li id="enterprise"><a href="#">Enterprise / Techcrunchit</a></li>
        </ul>
      
        <div id='feed'></div>
        
      </div>
      
      <div id="display_one_post" style="display:none">
      	<div id="title"></div>
      	<div id="post_text"></div>
      	<hr style="border:none; border-top:5px #CCCCCC solid; height:1px" />
      	<div id="comment_section">
      	   <h3>Comments</h3>
      	   <hr style="border:none; border-top:1px #CCCCCC solid; height:1px" />
      	   <div id="comments"></div>
      	   Username: &nbsp;&nbsp; <input type="text" id="username_info" /></br>
      	   Comment: &nbsp;&nbsp;&nbsp;&nbsp;<textarea id="comment_text" rows="5" cols="50"></textarea>
      	</div></br>
      	<button id="post_comment" class="btn btn-primary btn-success btn-large">Post Comment!</button>
      	<hr style="border:none; border-top:5px #CCCCCC solid; height:1px" />
      	<button id="back" class="btn btn-primary btn-large">Back to Feeds!</button></br></br>
      </div>
      
      <div id="myContactModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Contact</h3>
         </div>
         <div class="modal-body">
         	<div style="float:left">
               <p>Feel free to contact me at the following email addresses!</p>
               <h4>nnarayen@berkeley.edu<h4>
               <h4>nikhil.narayen@gmail.com<h4>
            </div>
            <img src="http://migopiccenter.appspot.com/pics/nikhil_profile.jpg" height="70px" width="70px" style="float:right" />
         </div>
         <div class="modal-footer">
           <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
      </div>
      
	</div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
	<script src="bootstrap-collapse.js"></script>
	<script src="bootstrap-transition.js"></script>
	<script src="bootstrap-modal.js"></script>
  </body>
</html>
