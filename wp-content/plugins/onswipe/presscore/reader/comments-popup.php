<?php

global $PressCore;
$accent_color   = $PressCore->options['accent_color'];
$contrast_color = best_contrast_color( $accent_color, '#333', '#fff' );

// get the current post
$id = intval( $_GET['comments_popup'] );
query_posts( array( 'p' => $id ) );

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="<?php echo get_option( 'blog_charset' ); ?>" />
    <title><?php printf( __( '%1$s - Comments on %2$s' ), get_option( 'blogname' ), the_title( '', '', false ) ); ?></title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

	<style type="text/css" media="screen">

		*{
			margin:0;
			padding:0;
		}

		body{
			font-family:helvetica;
			font-size:14px;
			line-height:1.5em;
			color:#333;
			padding-top:40px;
			background:#f0f0f0;
		}

		h2#comments-title{
			font-weight:normal;
			text-indent:30px;
			-webkit-box-sizing:border-box;
			padding:0 10px;
			font-size:16px;
			width:100%;
			height:40px;
			line-height:40px;
			color:<?php echo $contrast_color ?>;
			background:<?php echo $accent_color ?>;
			position:fixed;
			top:0;
			left:0;
			-webkit-box-shadow:rgba(0,0,0,.3) 0 0 15px, rgba(0,0,0,.3) 0 5px 15px inset;
			z-index:910;
		}

		#comments{
			padding:20px;
			padding-right:300px;
		}

		#respond{
			-webkit-box-sizing:border-box;
			width:300px;
			height:100%;
			position:fixed;
			right:0;
			top:0;
			padding:20px;
			padding-top:60px;
			background:#ececec;
			border-left:1px solid #e7e7e7;
			z-index:900;
		}



		ol.commentlist{
			list-style-type:none;
			height:400px;
			overflow:scroll;
			-webkit-overflow-scrolling: touch;
		}
			ul.children{
				list-style-type:none;
			}

			li.comment{
				padding:20px;
				border-bottom:1px solid #e7e7e7;
				color:#444;
			}

			li li.comment:first-child{
				margin-top:20px;
				border-top:1px solid #e7e7e7;
			}

			li.comment.alt{
				background:#f4f4f4;
			}

				li.comment.alt .alt{
					background:#f0f0f0;
				}

			li.comment.new{
				background:#ffff9d;
			}

			.comment-author{
				line-height:32px;
				height:32px;
				padding-left:38px;
				position:relative;
			}

				.avatar{
					position:absolute;
					left:0;
					top:0;
					width:28px;
					height:28px;
					padding:2px;
					background:#fff;
					-webkit-box-shadow:rgba(0,0,0,.3) 0 0 4px;
				}

				span.fn{
					color:#333;
					font-weight:bold;
				}

				time{
					font-style:italic;
				}

			.comment-meta{
				position:relative;
				font-size:13px;
				color:#555;
				margin-bottom:10px;
			}

			.reply-link{
				position:absolute;
				top:0;
				right:0;
			}

		.form-allowed-tags{
			display:none;
		}

		a.cancel{
			color:red;
			position:relative;
			top:-20px;
			left:110px;
			font-size:11px;
			text-decoration:none;
		}


		#author, #email, #url, #comment{
			width:200px;
			padding:4px;
			border:none;
			background:#f3f3f3;
			border-bottom:1px solid #ddd;
			margin-bottom:3px;
			font-size:13px;
			line-height:21px;
		}

		#comment{
			height:110px;
		}

		#reply-title{
			color:#666;
			font-size:13px;
			line-height:28px;
			font-weight:normal;
			text-transform:uppercase;
			letter-spacing:0.125em;
		}

		input:focus, textarea:focus{
			background:#f9f9f9;
		}

	</style>
</head>
<body>
	<?php if ( have_posts() ): while ( have_posts() ): the_post();?>
		<?php comments_template(); ?>
	<?php endwhile; ?>
	<?php endif ?>
	<script type="text/javascript" charset="utf-8">


		// fix the comments list height
		$( 'ol.commentlist' ).height( $( document ).height() - 80 );


		// init variables
		var $form = $( '#respond form' )
		,   $title = $( '#reply-title' )
		,   regularTitle = $title.html()
		,   replyTitle = "<?php echo __( 'Reply to ' ); ?>"
		,   replying = false
		,   parentInputTpl = "<input type='hidden' name='comment_parent' id='comment_parent' value=''>"
		,   $link
		,   cancelReply
		;


		// add a "cancel reply" link
		$link = $( '<a href="#" class="cancel"><?php echo __( 'Cancel Reply' ) ?></a>' )
		.hide()
		.click( function( e ){
			e.preventDefault();
			cancelReply();
		} );

		$form.append( $link );

		$( 'a.reply-link' ).click( function( e ){

			e.preventDefault();

			var $this = $( this );

			$title.html( replyTitle + ' ' + $this.data( 'author' ) );
			$( '#comment_parent' ).remove();
			$form.append( parentInputTpl );
			$( '#comment_parent' ).val( $this.data( 'id' ) );

			$link.show();

		});

		cancelReply = function(){

			$( '#comment_parent' ).remove();
			$title.html( regularTitle );

			$link.hide();

		}

		// add a redirect_to hiden field

		$form.append( "<input type='hidden' name='redirect_to' value='" + location.href + "'>" );

		$( location.hash ).parent().addClass( 'new' );

	</script>
</body>
</html>
