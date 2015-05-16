<?php include('header.php');
	include('nl2p.php');
//get latest posts from FB.
	$page_id = '1448422872085836';
	$access_token = '381904231984156|ed1d1adec8fa0ada6aba12edbef99917';
	//Get the JSON
	$json_object = @file_get_contents('https://graph.facebook.com/' . $page_id . 
	'/posts?limit=10&access_token=' . $access_token);
	//Interpret data
	$fbdata = json_decode($json_object); 

	$fb_url = 'https://www.facebook.com/';
	
//little helper function, thanks stackoverflow! 
//http://stackoverflow.com/questions/4323411/how-can-i-write-to-console-in-php
	function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}
	?>



	<div class="container">
	  <div class="row">
	  	<div class="col-md-4">
		  	<div class="page-header">
		  		<a class="anchor" name="press"></a><h1><a href="#press">Press</a></h1>
		  	</div>
	  	</div>
		</div><br />
<?php
	foreach ($fbdata->data as $post) {
		var_dump($post);
		
		if (!strpos($post->story, "likes a photo")) {
			$posts .= '<div class="row"> <div class="col-md-8 col-md-offset-1">'; // start of a post.

			// $grr = var_dump($post);
			// $posts .= '<h1>' . $grr . '</h1><br />';
			
			$posts .= '<h2>' . $post->name . '</h2>';
			$story = smarty_modifier_nl2p($post->story, true);
			$posts .= '<p><a href="' . $post->link . '">' . $story . '</a></p>';

			$message = smarty_modifier_nl2p($post->message, true);
			$posts .= '<p>' . $message . '</p>';

			$posts .= '<p class="post-description">' . $post->description . '</p>';
			
			if( !strpos($post->link, "youtube") ) {
				$posts .= '<p class="post-link"><a href="' . $post->link . '">';
			}
				//posting a link...
				if (isset($post->picture) && !strpos($post->link, "youtube")) {
					if (isset($post->picture) && isset($post->object_id) && !isset($post->properties)) {
						$posts .= '<img src="http://graph.facebook.com/' . $post->object_id . '/picture?type=normal&width=9999&height=9999" border="0">';
					} else {
						$posts .= '<img src="' . $post->picture . '">';
					}
				} elseif ($post->type == 'video') {
					$link = $post->link;
					$videoId = substr($link, strpos($link, "?v") + 3, 11);
					$posts .= '<iframe class="youtube-player" width="560" height="315" type="text/html" 
						src="http://www.youtube.com/embed/' . $videoId . '" frameborder="0" allowfullscreen></iframe>';
				} else {
					$posts .= $post->link;
				}
			
			$posts .= '</a></p>';

			/* Facebook Comments */
			$likes = $post->likes;
			$more_likes = $likes->paging;

			if (isset($more_likes) && isset($more_likes->next)) {
				// echo 'but there are more likes at: ' . $more_likes->next;
				$json_more_likes = @file_get_contents($more_likes->next);
				$json_decoded = json_decode($json_more_likes);
				
				foreach($json_decoded->data as $next) {
					array_push($likes->data, $next);
				}

				// echo 'first like: ' . $likes->data[0]->name;
			}
			
			$num_likes = count($likes->data);
			// echo 'num likes: ' . $num_likes;

			$comments = $post->comments;
			$more_comments = $comments->paging;

			if (isset($more_comments) && isset($more_comments->next)) {
				$json_more_comments = @file_get_contents($more_comments->next);
				$json_decoded = json_decode($json_more_comments);

				foreach($json_decoded->data as $next) {
					array_push($comments->data, $next);
				}
			}

			$num_comments = count($comments->data);

			$posts .= '<div class="row">
                    <div class="col-md-4" data-toggle="collapse" data-target="#'. $post->id . 'social">
                      <a style="margin-bottom: 10px;">'; 
      if ($num_likes > 0) {
      	$posts .= $num_likes . ' Likes';
      } else {
      	$posts .= 'Like';
      }

      $posts .= ' | ';

      if ($num_comments > 0) {
      	$posts .= $num_comments . ' Comments';
      } else {
      	$posts .= 'Comment';
      }

      $posts .= '</a>
                  </div>
                    <div class="col-md-3 col-md-offset-5"><a href="' . $post->link . '">View on Facebook</a></div>
                  </div>
                  <div id="' . $post->id . 'social" class="collapse" style="margin-top: 10px;">';

							      /* People who like this */
							      if ($num_likes > 0) {      	
							      	$posts .= '<p>';

							      	$i = 0;
							      	foreach($likes->data as $like ) {
							      		$posts .= '<a href="' . $fb_url . $like->id . '">' . $like->name . '</a>, '; 
							      		$i++;
							      		if ($i > 1) {
							      			break;
							      		}
							      	}
							      	$count = count($likes->data)-$i;
							      	$posts .= 'and <a href="' . $post->link . '">'. $count . ' others</a> like this.</p>';
							      } else {
							      	// nothing happens.
							      }

							      if ($num_comments > 0) {
							      	$posts .= '<p>';

											$i = 0;
							      	foreach($comments->data as $comment) {
							      		$posts .= '<a href="' . $fb_url . $comment->from->id . '">' . $comment->from->name . '</a> ';
							      		$posts .= $comment->message . '</p>'; 
							      		$i++;
							      		if ($i > 1) {
							      			break;
							      		}
							      	}
							      	$count = count($comments->data)-$i;

							      	if ($count > 0) {
							      		$posts .= '<p>' . $count . ' others commented on this.</p>';
							      	}
							      } else {
							      	$posts .= '</p><a href="' . $fb_url . '">Comment on Facebook</a></p>';	
							      }
      
			$posts .= '</div></div></div><br />';
			echo $posts;
			$posts = '';
		}
	}

	foreach ($fbdata->paging as $paging) {
		var_dump($paging);
	}
?>
	</div>
</div>

<?php include('footer.php'); ?>