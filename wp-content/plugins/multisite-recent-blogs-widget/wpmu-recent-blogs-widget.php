
    

  

<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <title>wp-content/plugins/multisite-recent-blogs-widget/wpmu-recent-blogs-widget.php at master from btompkins/CodeBetter.Com-Wordpress - GitHub</title>
    <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="GitHub" />
    <link rel="fluid-icon" href="https://github.com/fluidicon.png" title="GitHub" />

    <link href="https://d3nwyuy0nl342s.cloudfront.net/059ebbfb26cc3f47e727f59297076b08fac34c23/stylesheets/bundle_common.css" media="screen" rel="stylesheet" type="text/css" />
<link href="https://d3nwyuy0nl342s.cloudfront.net/059ebbfb26cc3f47e727f59297076b08fac34c23/stylesheets/bundle_github.css" media="screen" rel="stylesheet" type="text/css" />
    

    <script type="text/javascript">
      if (typeof console == "undefined" || typeof console.log == "undefined")
        console = { log: function() {} }
    </script>
    <script type="text/javascript" charset="utf-8">
      var GitHub = {
        assetHost: 'https://d3nwyuy0nl342s.cloudfront.net'
      }
      var github_user = null
      
    </script>
    <script src="https://d3nwyuy0nl342s.cloudfront.net/059ebbfb26cc3f47e727f59297076b08fac34c23/javascripts/jquery/jquery-1.4.2.min.js" type="text/javascript"></script>
    <script src="https://d3nwyuy0nl342s.cloudfront.net/059ebbfb26cc3f47e727f59297076b08fac34c23/javascripts/bundle_common.js" type="text/javascript"></script>
<script src="https://d3nwyuy0nl342s.cloudfront.net/059ebbfb26cc3f47e727f59297076b08fac34c23/javascripts/bundle_github.js" type="text/javascript"></script>


    
    <script type="text/javascript" charset="utf-8">
      GitHub.spy({
        repo: "btompkins/CodeBetter.Com-Wordpress"
      })
    </script>

    
  <link href="https://github.com/btompkins/CodeBetter.Com-Wordpress/commits/master.atom" rel="alternate" title="Recent Commits to CodeBetter.Com-Wordpress:master" type="application/atom+xml" />

        <meta name="description" content="CodeBetter.Com Wordpress Source" />
    <script type="text/javascript">
      GitHub.nameWithOwner = GitHub.nameWithOwner || "btompkins/CodeBetter.Com-Wordpress";
      GitHub.currentRef = 'master';
      GitHub.commitSHA = "6d4a407f607b8b580d5cbc78544ef5798a9c3bfd";
      GitHub.currentPath = 'wp-content/plugins/multisite-recent-blogs-widget/wpmu-recent-blogs-widget.php';
      GitHub.masterBranch = "master";

      
    </script>
  

        <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-3769691-2']);
      _gaq.push(['_setDomainName', 'none']);
      _gaq.push(['_trackPageview']);
      (function() {
        var ga = document.createElement('script');
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        ga.setAttribute('async', 'true');
        document.documentElement.firstChild.appendChild(ga);
      })();
    </script>

    
  </head>

  

  <body class="logged_out page-blob">
    

    

    

    

    

    <div class="subnavd" id="main">
      <div id="header" class="true">
        
          <a class="logo boring" href="https://github.com">
            <img alt="github" class="default" src="https://d3nwyuy0nl342s.cloudfront.net/images/modules/header/logov3.png" />
            <!--[if (gt IE 8)|!(IE)]><!-->
            <img alt="github" class="hover" src="https://d3nwyuy0nl342s.cloudfront.net/images/modules/header/logov3-hover.png" />
            <!--<![endif]-->
          </a>
        
        
        <div class="topsearch">
  
    <ul class="nav logged_out">
      <li class="pricing"><a href="/plans">Pricing and Signup</a></li>
      <li class="explore"><a href="/explore">Explore GitHub</a></li>
      <li class="features"><a href="/features">Features</a></li>
      <li class="blog"><a href="/blog">Blog</a></li>
      <li class="login"><a href="/login?return_to=https://github.com/btompkins/CodeBetter.Com-Wordpress/blob/master/wp-content/plugins/multisite-recent-blogs-widget/wpmu-recent-blogs-widget.php">Login</a></li>
    </ul>
  
</div>

      </div>

      
      
        
    <div class="site">
      <div class="pagehead repohead vis-public    instapaper_ignore readability-menu">

      

      <div class="title-actions-bar">
        <h1>
          <a href="/btompkins">btompkins</a> / <strong><a href="https://github.com/btompkins/CodeBetter.Com-Wordpress">CodeBetter.Com-Wordpress</a></strong>
          
          
        </h1>

        
    <ul class="actions">
      

      
        <li class="for-owner" style="display:none"><a href="https://github.com/btompkins/CodeBetter.Com-Wordpress/admin" class="minibutton btn-admin "><span><span class="icon"></span>Admin</span></a></li>
        <li>
          <a href="/btompkins/CodeBetter.Com-Wordpress/toggle_watch" class="minibutton btn-watch " id="watch_button" onclick="var f = document.createElement('form'); f.style.display = 'none'; this.parentNode.appendChild(f); f.method = 'POST'; f.action = this.href;var s = document.createElement('input'); s.setAttribute('type', 'hidden'); s.setAttribute('name', 'authenticity_token'); s.setAttribute('value', '9b0b9e794cab0fd5d3394ee62b4c0b5c6bac57c8'); f.appendChild(s);f.submit();return false;" style="display:none"><span><span class="icon"></span>Watch</span></a>
          <a href="/btompkins/CodeBetter.Com-Wordpress/toggle_watch" class="minibutton btn-watch " id="unwatch_button" onclick="var f = document.createElement('form'); f.style.display = 'none'; this.parentNode.appendChild(f); f.method = 'POST'; f.action = this.href;var s = document.createElement('input'); s.setAttribute('type', 'hidden'); s.setAttribute('name', 'authenticity_token'); s.setAttribute('value', '9b0b9e794cab0fd5d3394ee62b4c0b5c6bac57c8'); f.appendChild(s);f.submit();return false;" style="display:none"><span><span class="icon"></span>Unwatch</span></a>
        </li>
        
          
            <li class="for-notforked" style="display:none"><a href="/btompkins/CodeBetter.Com-Wordpress/fork" class="minibutton btn-fork " id="fork_button" onclick="var f = document.createElement('form'); f.style.display = 'none'; this.parentNode.appendChild(f); f.method = 'POST'; f.action = this.href;var s = document.createElement('input'); s.setAttribute('type', 'hidden'); s.setAttribute('name', 'authenticity_token'); s.setAttribute('value', '9b0b9e794cab0fd5d3394ee62b4c0b5c6bac57c8'); f.appendChild(s);f.submit();return false;"><span><span class="icon"></span>Fork</span></a></li>
            <li class="for-hasfork" style="display:none"><a href="#" class="minibutton btn-fork " id="your_fork_button"><span><span class="icon"></span>Your Fork</span></a></li>
          

          
        
      
      
      <li class="repostats">
        <ul class="repo-stats">
          <li class="watchers"><a href="/btompkins/CodeBetter.Com-Wordpress/watchers" title="Watchers" class="tooltipped downwards">1</a></li>
          <li class="forks"><a href="/btompkins/CodeBetter.Com-Wordpress/network" title="Forks" class="tooltipped downwards">1</a></li>
        </ul>
      </li>
    </ul>

      </div>

        
  <ul class="tabs">
    <li><a href="https://github.com/btompkins/CodeBetter.Com-Wordpress" class="selected" highlight="repo_source">Source</a></li>
    <li><a href="https://github.com/btompkins/CodeBetter.Com-Wordpress/commits/master" highlight="repo_commits">Commits</a></li>
    <li><a href="/btompkins/CodeBetter.Com-Wordpress/network" highlight="repo_network">Network</a></li>
    <li><a href="/btompkins/CodeBetter.Com-Wordpress/pulls" highlight="repo_pulls">Pull Requests (0)</a></li>

    

    
      
      <li><a href="/btompkins/CodeBetter.Com-Wordpress/issues" highlight="issues">Issues (3)</a></li>
    

            
    <li><a href="/btompkins/CodeBetter.Com-Wordpress/graphs" highlight="repo_graphs">Graphs</a></li>

    <li class="contextswitch nochoices">
      <span class="toggle leftwards" >
        <em>Branch:</em>
        <code>master</code>
      </span>
    </li>
  </ul>

  <div style="display:none" id="pl-description"><p><em class="placeholder">click here to add a description</em></p></div>
  <div style="display:none" id="pl-homepage"><p><em class="placeholder">click here to add a homepage</em></p></div>

  <div class="subnav-bar">
  
  <ul>
    <li>
      
      <a href="/btompkins/CodeBetter.Com-Wordpress/branches" class="dropdown">Switch Branches (1)</a>
      <ul>
        
          
            <li><strong>master &#x2713;</strong></li>
            
      </ul>
    </li>
    <li>
      <a href="#" class="dropdown defunct">Switch Tags (0)</a>
      
    </li>
    <li>
    
    <a href="/btompkins/CodeBetter.Com-Wordpress/branches" class="manage">Branch List</a>
    
    </li>
  </ul>
</div>

  
  
  
  
  
  



        
    <div id="repo_details" class="metabox clearfix">
      <div id="repo_details_loader" class="metabox-loader" style="display:none">Sending Request&hellip;</div>

        <a href="/btompkins/CodeBetter.Com-Wordpress/downloads" class="download-source" id="download_button" title="Download source, tagged packages and binaries."><span class="icon"></span>Downloads</a>

      <div id="repository_desc_wrapper">
      <div id="repository_description" rel="repository_description_edit">
        
          <p>CodeBetter.Com Wordpress Source
            <span id="read_more" style="display:none">&mdash; <a href="#readme">Read more</a></span>
          </p>
        
      </div>

      <div id="repository_description_edit" style="display:none;" class="inline-edit">
        <form action="/btompkins/CodeBetter.Com-Wordpress/admin/update" method="post"><div style="margin:0;padding:0"><input name="authenticity_token" type="hidden" value="9b0b9e794cab0fd5d3394ee62b4c0b5c6bac57c8" /></div>
          <input type="hidden" name="field" value="repository_description">
          <input type="text" class="textfield" name="value" value="CodeBetter.Com Wordpress Source">
          <div class="form-actions">
            <button class="minibutton"><span>Save</span></button> &nbsp; <a href="#" class="cancel">Cancel</a>
          </div>
        </form>
      </div>

      
      <div class="repository-homepage" id="repository_homepage" rel="repository_homepage_edit">
        <p><a href="http://" rel="nofollow"></a></p>
      </div>

      <div id="repository_homepage_edit" style="display:none;" class="inline-edit">
        <form action="/btompkins/CodeBetter.Com-Wordpress/admin/update" method="post"><div style="margin:0;padding:0"><input name="authenticity_token" type="hidden" value="9b0b9e794cab0fd5d3394ee62b4c0b5c6bac57c8" /></div>
          <input type="hidden" name="field" value="repository_homepage">
          <input type="text" class="textfield" name="value" value="">
          <div class="form-actions">
            <button class="minibutton"><span>Save</span></button> &nbsp; <a href="#" class="cancel">Cancel</a>
          </div>
        </form>
      </div>
      </div>
      <div class="rule "></div>
            <div id="url_box" class="url-box">
        <ul class="clone-urls">
          
            
            <li id="http_clone_url"><a href="https://github.com/btompkins/CodeBetter.Com-Wordpress.git" data-permissions="Read-Only">HTTP</a></li>
            <li id="public_clone_url"><a href="git://github.com/btompkins/CodeBetter.Com-Wordpress.git" data-permissions="Read-Only">Git Read-Only</a></li>
          
          
        </ul>
        <input type="text" spellcheck="false" id="url_field" class="url-field" />
              <span style="display:none" id="url_box_clippy"></span>
      <span id="clippy_tooltip_url_box_clippy" class="clippy-tooltip tooltipped" title="copy to clipboard">
      <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
              width="14"
              height="14"
              class="clippy"
              id="clippy" >
      <param name="movie" value="https://d3nwyuy0nl342s.cloudfront.net/flash/clippy.swf?v5"/>
      <param name="allowScriptAccess" value="always" />
      <param name="quality" value="high" />
      <param name="scale" value="noscale" />
      <param NAME="FlashVars" value="id=url_box_clippy&amp;copied=&amp;copyto=">
      <param name="bgcolor" value="#FFFFFF">
      <param name="wmode" value="opaque">
      <embed src="https://d3nwyuy0nl342s.cloudfront.net/flash/clippy.swf?v5"
             width="14"
             height="14"
             name="clippy"
             quality="high"
             allowScriptAccess="always"
             type="application/x-shockwave-flash"
             pluginspage="http://www.macromedia.com/go/getflashplayer"
             FlashVars="id=url_box_clippy&amp;copied=&amp;copyto="
             bgcolor="#FFFFFF"
             wmode="opaque"
      />
      </object>
      </span>

        <p id="url_description">This URL has <strong>Read+Write</strong> access</p>
      </div>
    </div>

    <div class="frame frame-center tree-finder" style="display:none">
      <div class="breadcrumb">
        <b><a href="/btompkins/CodeBetter.Com-Wordpress">CodeBetter.Com-Wordpress</a></b> /
        <input class="tree-finder-input" type="text" name="query" autocomplete="off" spellcheck="false">
      </div>

      
        <div class="octotip">
          <p>
            <a href="/btompkins/CodeBetter.Com-Wordpress/dismiss-tree-finder-help" class="dismiss js-dismiss-tree-list-help" title="Hide this notice forever">Dismiss</a>
            <strong>Octotip:</strong> You've activated the <em>file finder</em> by pressing <span class="kbd">t</span>
            Start typing to filter the file list. Use <span class="kbd badmono">↑</span> and <span class="kbd badmono">↓</span> to navigate,
            <span class="kbd">enter</span> to view files.
          </p>
        </div>
      

      <table class="tree-browser" cellpadding="0" cellspacing="0">
        <tr class="js-header"><th>&nbsp;</th><th>name</th></tr>
        <tr class="js-no-results no-results" style="display: none">
          <th colspan="2">No matching files</th>
        </tr>
        <tbody class="js-results-list">
        </tbody>
      </table>
    </div>

    <div id="jump-to-line" style="display:none">
      <h2>Jump to Line</h2>
      <form>
        <input class="textfield" type="text">
        <div class="full-button">
          <button type="submit" class="classy">
            <span>Go</span>
          </button>
        </div>
      </form>
    </div>


        

      </div><!-- /.pagehead -->

      

  





<script type="text/javascript">
  GitHub.downloadRepo = '/btompkins/CodeBetter.Com-Wordpress/archives/master'
  GitHub.revType = "master"

  GitHub.controllerName = "blob"
  GitHub.actionName     = "show"
  GitHub.currentAction  = "blob#show"

  

  
</script>






<div class="flash-messages"></div>


  <div id="commit">
    <div class="group">
        
  <div class="envelope commit">
    <div class="human">
      
        <div class="message"><pre><a href="/btompkins/CodeBetter.Com-Wordpress/commit/6d4a407f607b8b580d5cbc78544ef5798a9c3bfd">Add wp-config to gitignore</a> </pre></div>
      

      <div class="actor">
        <div class="gravatar">
          
          <img src="https://secure.gravatar.com/avatar/b9a9f2e092b6cfd8483c38a0b66b1f83?s=140&d=https://d3nwyuy0nl342s.cloudfront.net%2Fimages%2Fgravatars%2Fgravatar-140.png" alt="" width="30" height="30"  />
        </div>
        <div class="name">brendan <span>(author)</span></div>
        <div class="date">
          <abbr class="relatize" title="2011-02-22 12:51:53">Tue Feb 22 12:51:53 -0800 2011</abbr>
        </div>
      </div>

      

    </div>
    <div class="machine">
      <span>c</span>ommit&nbsp;&nbsp;<a href="/btompkins/CodeBetter.Com-Wordpress/commit/6d4a407f607b8b580d5cbc78544ef5798a9c3bfd" hotkey="c">6d4a407f607b8b580d5c</a><br />
      <span>t</span>ree&nbsp;&nbsp;&nbsp;&nbsp;<a href="/btompkins/CodeBetter.Com-Wordpress/tree/6d4a407f607b8b580d5cbc78544ef5798a9c3bfd/wp-content" hotkey="t">3d60e391b92e67001c44</a><br />
      
        <span>p</span>arent&nbsp;
        
        <a href="/btompkins/CodeBetter.Com-Wordpress/tree/decf874d4da6ea3da5ea7e4e9cb79a89f95116d9/wp-content" hotkey="p">decf874d4da6ea3da5ea</a>
      

    </div>
  </div>

    </div>
  </div>



  <div id="slider">

  

    <div class="breadcrumb" data-path="wp-content/plugins/multisite-recent-blogs-widget/wpmu-recent-blogs-widget.php/">
      <b><a href="/btompkins/CodeBetter.Com-Wordpress/tree/6d4a407f607b8b580d5cbc78544ef5798a9c3bfd">CodeBetter.Com-Wordpress</a></b> / <a href="/btompkins/CodeBetter.Com-Wordpress/tree/6d4a407f607b8b580d5cbc78544ef5798a9c3bfd/wp-content">wp-content</a> / <a href="/btompkins/CodeBetter.Com-Wordpress/tree/6d4a407f607b8b580d5cbc78544ef5798a9c3bfd/wp-content/plugins">plugins</a> / <a href="/btompkins/CodeBetter.Com-Wordpress/tree/6d4a407f607b8b580d5cbc78544ef5798a9c3bfd/wp-content/plugins/multisite-recent-blogs-widget">multisite-recent-blogs-widget</a> / wpmu-recent-blogs-widget.php       <span style="display:none" id="clippy_4272">wp-content/plugins/multisite-recent-blogs-widget/wpmu-recent-blogs-widget.php</span>
      
      <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
              width="110"
              height="14"
              class="clippy"
              id="clippy" >
      <param name="movie" value="https://d3nwyuy0nl342s.cloudfront.net/flash/clippy.swf?v5"/>
      <param name="allowScriptAccess" value="always" />
      <param name="quality" value="high" />
      <param name="scale" value="noscale" />
      <param NAME="FlashVars" value="id=clippy_4272&amp;copied=copied!&amp;copyto=copy to clipboard">
      <param name="bgcolor" value="#FFFFFF">
      <param name="wmode" value="opaque">
      <embed src="https://d3nwyuy0nl342s.cloudfront.net/flash/clippy.swf?v5"
             width="110"
             height="14"
             name="clippy"
             quality="high"
             allowScriptAccess="always"
             type="application/x-shockwave-flash"
             pluginspage="http://www.macromedia.com/go/getflashplayer"
             FlashVars="id=clippy_4272&amp;copied=copied!&amp;copyto=copy to clipboard"
             bgcolor="#FFFFFF"
             wmode="opaque"
      />
      </object>
      

    </div>

    <div class="frames">
      <div class="frame frame-center" data-path="wp-content/plugins/multisite-recent-blogs-widget/wpmu-recent-blogs-widget.php/">
        
          <ul class="big-actions">
            
            <li><a class="file-edit-link minibutton" href="/btompkins/CodeBetter.Com-Wordpress/file-edit/__current_ref__/wp-content/plugins/multisite-recent-blogs-widget/wpmu-recent-blogs-widget.php"><span>Edit this file</span></a></li>
          </ul>
        

        <div id="files">
          <div class="file">
            <div class="meta">
              <div class="info">
                <span class="icon"><img alt="Txt" height="16" src="https://d3nwyuy0nl342s.cloudfront.net/images/icons/txt.png" width="16" /></span>
                <span class="mode" title="File Mode">100644</span>
                
                  <span>153 lines (132 sloc)</span>
                
                <span>5.364 kb</span>
              </div>
              <ul class="actions">
                <li><a href="/btompkins/CodeBetter.Com-Wordpress/raw/master/wp-content/plugins/multisite-recent-blogs-widget/wpmu-recent-blogs-widget.php" id="raw-url">raw</a></li>
                
                  <li><a href="/btompkins/CodeBetter.Com-Wordpress/blame/master/wp-content/plugins/multisite-recent-blogs-widget/wpmu-recent-blogs-widget.php">blame</a></li>
                
                <li><a href="/btompkins/CodeBetter.Com-Wordpress/commits/master/wp-content/plugins/multisite-recent-blogs-widget/wpmu-recent-blogs-widget.php">history</a></li>
              </ul>
            </div>
            
  <div class="data type-php">
    
      <table cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <pre class="line_numbers"><span id="L1" rel="#L1">1</span>
<span id="L2" rel="#L2">2</span>
<span id="L3" rel="#L3">3</span>
<span id="L4" rel="#L4">4</span>
<span id="L5" rel="#L5">5</span>
<span id="L6" rel="#L6">6</span>
<span id="L7" rel="#L7">7</span>
<span id="L8" rel="#L8">8</span>
<span id="L9" rel="#L9">9</span>
<span id="L10" rel="#L10">10</span>
<span id="L11" rel="#L11">11</span>
<span id="L12" rel="#L12">12</span>
<span id="L13" rel="#L13">13</span>
<span id="L14" rel="#L14">14</span>
<span id="L15" rel="#L15">15</span>
<span id="L16" rel="#L16">16</span>
<span id="L17" rel="#L17">17</span>
<span id="L18" rel="#L18">18</span>
<span id="L19" rel="#L19">19</span>
<span id="L20" rel="#L20">20</span>
<span id="L21" rel="#L21">21</span>
<span id="L22" rel="#L22">22</span>
<span id="L23" rel="#L23">23</span>
<span id="L24" rel="#L24">24</span>
<span id="L25" rel="#L25">25</span>
<span id="L26" rel="#L26">26</span>
<span id="L27" rel="#L27">27</span>
<span id="L28" rel="#L28">28</span>
<span id="L29" rel="#L29">29</span>
<span id="L30" rel="#L30">30</span>
<span id="L31" rel="#L31">31</span>
<span id="L32" rel="#L32">32</span>
<span id="L33" rel="#L33">33</span>
<span id="L34" rel="#L34">34</span>
<span id="L35" rel="#L35">35</span>
<span id="L36" rel="#L36">36</span>
<span id="L37" rel="#L37">37</span>
<span id="L38" rel="#L38">38</span>
<span id="L39" rel="#L39">39</span>
<span id="L40" rel="#L40">40</span>
<span id="L41" rel="#L41">41</span>
<span id="L42" rel="#L42">42</span>
<span id="L43" rel="#L43">43</span>
<span id="L44" rel="#L44">44</span>
<span id="L45" rel="#L45">45</span>
<span id="L46" rel="#L46">46</span>
<span id="L47" rel="#L47">47</span>
<span id="L48" rel="#L48">48</span>
<span id="L49" rel="#L49">49</span>
<span id="L50" rel="#L50">50</span>
<span id="L51" rel="#L51">51</span>
<span id="L52" rel="#L52">52</span>
<span id="L53" rel="#L53">53</span>
<span id="L54" rel="#L54">54</span>
<span id="L55" rel="#L55">55</span>
<span id="L56" rel="#L56">56</span>
<span id="L57" rel="#L57">57</span>
<span id="L58" rel="#L58">58</span>
<span id="L59" rel="#L59">59</span>
<span id="L60" rel="#L60">60</span>
<span id="L61" rel="#L61">61</span>
<span id="L62" rel="#L62">62</span>
<span id="L63" rel="#L63">63</span>
<span id="L64" rel="#L64">64</span>
<span id="L65" rel="#L65">65</span>
<span id="L66" rel="#L66">66</span>
<span id="L67" rel="#L67">67</span>
<span id="L68" rel="#L68">68</span>
<span id="L69" rel="#L69">69</span>
<span id="L70" rel="#L70">70</span>
<span id="L71" rel="#L71">71</span>
<span id="L72" rel="#L72">72</span>
<span id="L73" rel="#L73">73</span>
<span id="L74" rel="#L74">74</span>
<span id="L75" rel="#L75">75</span>
<span id="L76" rel="#L76">76</span>
<span id="L77" rel="#L77">77</span>
<span id="L78" rel="#L78">78</span>
<span id="L79" rel="#L79">79</span>
<span id="L80" rel="#L80">80</span>
<span id="L81" rel="#L81">81</span>
<span id="L82" rel="#L82">82</span>
<span id="L83" rel="#L83">83</span>
<span id="L84" rel="#L84">84</span>
<span id="L85" rel="#L85">85</span>
<span id="L86" rel="#L86">86</span>
<span id="L87" rel="#L87">87</span>
<span id="L88" rel="#L88">88</span>
<span id="L89" rel="#L89">89</span>
<span id="L90" rel="#L90">90</span>
<span id="L91" rel="#L91">91</span>
<span id="L92" rel="#L92">92</span>
<span id="L93" rel="#L93">93</span>
<span id="L94" rel="#L94">94</span>
<span id="L95" rel="#L95">95</span>
<span id="L96" rel="#L96">96</span>
<span id="L97" rel="#L97">97</span>
<span id="L98" rel="#L98">98</span>
<span id="L99" rel="#L99">99</span>
<span id="L100" rel="#L100">100</span>
<span id="L101" rel="#L101">101</span>
<span id="L102" rel="#L102">102</span>
<span id="L103" rel="#L103">103</span>
<span id="L104" rel="#L104">104</span>
<span id="L105" rel="#L105">105</span>
<span id="L106" rel="#L106">106</span>
<span id="L107" rel="#L107">107</span>
<span id="L108" rel="#L108">108</span>
<span id="L109" rel="#L109">109</span>
<span id="L110" rel="#L110">110</span>
<span id="L111" rel="#L111">111</span>
<span id="L112" rel="#L112">112</span>
<span id="L113" rel="#L113">113</span>
<span id="L114" rel="#L114">114</span>
<span id="L115" rel="#L115">115</span>
<span id="L116" rel="#L116">116</span>
<span id="L117" rel="#L117">117</span>
<span id="L118" rel="#L118">118</span>
<span id="L119" rel="#L119">119</span>
<span id="L120" rel="#L120">120</span>
<span id="L121" rel="#L121">121</span>
<span id="L122" rel="#L122">122</span>
<span id="L123" rel="#L123">123</span>
<span id="L124" rel="#L124">124</span>
<span id="L125" rel="#L125">125</span>
<span id="L126" rel="#L126">126</span>
<span id="L127" rel="#L127">127</span>
<span id="L128" rel="#L128">128</span>
<span id="L129" rel="#L129">129</span>
<span id="L130" rel="#L130">130</span>
<span id="L131" rel="#L131">131</span>
<span id="L132" rel="#L132">132</span>
<span id="L133" rel="#L133">133</span>
<span id="L134" rel="#L134">134</span>
<span id="L135" rel="#L135">135</span>
<span id="L136" rel="#L136">136</span>
<span id="L137" rel="#L137">137</span>
<span id="L138" rel="#L138">138</span>
<span id="L139" rel="#L139">139</span>
<span id="L140" rel="#L140">140</span>
<span id="L141" rel="#L141">141</span>
<span id="L142" rel="#L142">142</span>
<span id="L143" rel="#L143">143</span>
<span id="L144" rel="#L144">144</span>
<span id="L145" rel="#L145">145</span>
<span id="L146" rel="#L146">146</span>
<span id="L147" rel="#L147">147</span>
<span id="L148" rel="#L148">148</span>
<span id="L149" rel="#L149">149</span>
<span id="L150" rel="#L150">150</span>
<span id="L151" rel="#L151">151</span>
<span id="L152" rel="#L152">152</span>
<span id="L153" rel="#L153">153</span>
</pre>
          </td>
          <td width="100%">
            
              
                <div class="highlight"><pre><div class='line' id='LC1'><span class="cp">&lt;?php</span></div><div class='line' id='LC2'><span class="cm">/*</span></div><div class='line' id='LC3'><span class="cm">Plugin Name: WPMU Recent Blogs Widget</span></div><div class='line' id='LC4'><span class="cm">Plugin URI: http://wordpress.org/extend/plugins/multisite-recent-posts-widget/</span></div><div class='line' id='LC5'><span class="cm">Description: Creates a widget to show a list of the most recent posts across a WordPress MU installation.  This plugin is based on the work of many authors.</span></div><div class='line' id='LC6'><span class="cm">Version: 1.1</span></div><div class='line' id='LC7'><span class="cm">Author: Angelo</span></div><div class='line' id='LC8'><span class="cm">Author URI: http://bitfreedom.com/</span></div><div class='line' id='LC9'><span class="cm">*/</span></div><div class='line' id='LC10'><br/></div><div class='line' id='LC11'><span class="cm">/*</span></div><div class='line' id='LC12'><span class="cm">Parameter explanations</span></div><div class='line' id='LC13'><span class="cm">$how_many: how many recent posts are being displayed</span></div><div class='line' id='LC14'><span class="cm">$how_long: time frame to choose recent posts from (in days), set to 0 to disable</span></div><div class='line' id='LC15'><span class="cm">$titleOnly: true (only title of post is displayed) OR false (title of post and name of blog are displayed)</span></div><div class='line' id='LC16'><span class="cm">$begin_wrap: customise the start html code to adapt to different themes</span></div><div class='line' id='LC17'><span class="cm">$end_wrap: customise the end html code to adapt to different themes</span></div><div class='line' id='LC18'><br/></div><div class='line' id='LC19'><span class="cm">Sample call: wpmu_recent_blogs_mu(5, 30, true, &#39;&lt;li&gt;&#39;, &#39;&lt;/li&gt;&#39;); &gt;&gt; 5 most recent entries over the past 30 days, displaying titles only</span></div><div class='line' id='LC20'><span class="cm">*/</span></div><div class='line' id='LC21'><br/></div><div class='line' id='LC22'><span class="k">function</span> <span class="nf">wpmu_recent_blogs_mu</span><span class="p">(</span><span class="nv">$how_many</span><span class="o">=</span><span class="m">10</span><span class="p">,</span> <span class="nv">$how_long</span><span class="o">=</span><span class="m">0</span><span class="p">,</span> <span class="nv">$titleOnly</span><span class="o">=</span><span class="k">true</span><span class="p">,</span> <span class="nv">$begin_wrap</span><span class="o">=</span><span class="s2">&quot;</span><span class="se">\n</span><span class="s2">&lt;li&gt;&quot;</span><span class="p">,</span> <span class="nv">$end_wrap</span><span class="o">=</span><span class="s2">&quot;&lt;/li&gt;&quot;</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC23'>	<span class="k">global</span> <span class="nv">$wpdb</span><span class="p">;</span></div><div class='line' id='LC24'>	<span class="k">global</span> <span class="nv">$table_prefix</span><span class="p">;</span></div><div class='line' id='LC25'>	<span class="nv">$counter</span> <span class="o">=</span> <span class="m">0</span><span class="p">;</span></div><div class='line' id='LC26'><br/></div><div class='line' id='LC27'>	<span class="c1">// get a list of blogs in order of most recent update. show only public and nonarchived/spam/mature/deleted</span></div><div class='line' id='LC28'>	<span class="k">if</span> <span class="p">(</span><span class="nv">$how_long</span> <span class="o">&gt;</span> <span class="m">0</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC29'>		<span class="nv">$blogs</span> <span class="o">=</span> <span class="nv">$wpdb</span><span class="o">-&gt;</span><span class="na">get_col</span><span class="p">(</span><span class="s2">&quot;SELECT blog_id FROM </span><span class="si">$wpdb-&gt;blogs</span><span class="s2"> WHERE</span></div><div class='line' id='LC30'><span class="s2">			public = &#39;1&#39; AND archived = &#39;0&#39; AND mature = &#39;0&#39; AND spam = &#39;0&#39; AND deleted = &#39;0&#39;</span></div><div class='line' id='LC31'><span class="s2">			AND last_updated &gt;= DATE_SUB(CURRENT_DATE(), INTERVAL </span><span class="si">$how_long</span><span class="s2"> DAY)</span></div><div class='line' id='LC32'><span class="s2">			ORDER BY last_updated DESC&quot;</span><span class="p">);</span></div><div class='line' id='LC33'>	<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC34'>		<span class="nv">$blogs</span> <span class="o">=</span> <span class="nv">$wpdb</span><span class="o">-&gt;</span><span class="na">get_col</span><span class="p">(</span><span class="s2">&quot;SELECT blog_id FROM </span><span class="si">$wpdb-&gt;blogs</span><span class="s2"> WHERE</span></div><div class='line' id='LC35'><span class="s2">			public = &#39;1&#39; AND archived = &#39;0&#39; AND mature = &#39;0&#39; AND spam = &#39;0&#39; AND deleted = &#39;0&#39;</span></div><div class='line' id='LC36'><span class="s2">			ORDER BY last_updated DESC&quot;</span><span class="p">);</span></div><div class='line' id='LC37'>	<span class="p">}</span></div><div class='line' id='LC38'><br/></div><div class='line' id='LC39'>	<span class="k">if</span> <span class="p">(</span><span class="nv">$blogs</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC40'>		<span class="c1">// Should we make &lt;ul&gt; optional since this is a widget now?</span></div><div class='line' id='LC41'>		<span class="k">echo</span> <span class="s2">&quot;&lt;ul&gt;&quot;</span><span class="p">;</span></div><div class='line' id='LC42'>		<span class="k">foreach</span> <span class="p">(</span><span class="nv">$blogs</span> <span class="k">as</span> <span class="nv">$blog</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC43'>			<span class="c1">// we need _posts and _options tables for this to work</span></div><div class='line' id='LC44'>			<span class="nv">$blogOptionsTable</span> <span class="o">=</span> <span class="nv">$wpdb</span><span class="o">-&gt;</span><span class="na">base_prefix</span><span class="o">.</span><span class="nv">$blog</span><span class="o">.</span><span class="s2">&quot;_options&quot;</span><span class="p">;</span></div><div class='line' id='LC45'>		    	<span class="nv">$blogPostsTable</span> <span class="o">=</span> <span class="nv">$wpdb</span><span class="o">-&gt;</span><span class="na">base_prefix</span><span class="o">.</span><span class="nv">$blog</span><span class="o">.</span><span class="s2">&quot;_posts&quot;</span><span class="p">;</span></div><div class='line' id='LC46'>			<span class="nv">$options</span> <span class="o">=</span> <span class="nv">$wpdb</span><span class="o">-&gt;</span><span class="na">get_results</span><span class="p">(</span><span class="s2">&quot;SELECT option_value FROM</span></div><div class='line' id='LC47'><span class="s2">				</span><span class="si">$blogOptionsTable</span><span class="s2"> WHERE option_name IN (&#39;siteurl&#39;,&#39;blogname&#39;) </span></div><div class='line' id='LC48'><span class="s2">				ORDER BY option_name DESC&quot;</span><span class="p">);</span></div><div class='line' id='LC49'>		        <span class="c1">// we fetch the title and ID for the latest post</span></div><div class='line' id='LC50'>			<span class="k">if</span> <span class="p">(</span><span class="nv">$how_long</span> <span class="o">&gt;</span> <span class="m">0</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC51'>				<span class="nv">$thispost</span> <span class="o">=</span> <span class="nv">$wpdb</span><span class="o">-&gt;</span><span class="na">get_results</span><span class="p">(</span><span class="s2">&quot;SELECT ID, post_title</span></div><div class='line' id='LC52'><span class="s2">					FROM </span><span class="si">$blogPostsTable</span><span class="s2"> WHERE post_status = &#39;publish&#39;</span></div><div class='line' id='LC53'><span class="s2">					AND ID &gt; 1</span></div><div class='line' id='LC54'><span class="s2">					AND post_type = &#39;post&#39;</span></div><div class='line' id='LC55'><span class="s2">					AND post_date &gt;= DATE_SUB(CURRENT_DATE(), INTERVAL </span><span class="si">$how_long</span><span class="s2"> DAY)</span></div><div class='line' id='LC56'><span class="s2">					ORDER BY id DESC LIMIT 0,1&quot;</span><span class="p">);</span></div><div class='line' id='LC57'>			<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC58'>				<span class="nv">$thispost</span> <span class="o">=</span> <span class="nv">$wpdb</span><span class="o">-&gt;</span><span class="na">get_results</span><span class="p">(</span><span class="s2">&quot;SELECT ID, post_title</span></div><div class='line' id='LC59'><span class="s2">					FROM </span><span class="si">$blogPostsTable</span><span class="s2"> WHERE post_status = &#39;publish&#39;</span></div><div class='line' id='LC60'><span class="s2">					AND ID &gt; 1</span></div><div class='line' id='LC61'><span class="s2">					AND post_type = &#39;post&#39;</span></div><div class='line' id='LC62'><span class="s2">					ORDER BY id DESC LIMIT 0,1&quot;</span><span class="p">);</span></div><div class='line' id='LC63'>			<span class="p">}</span></div><div class='line' id='LC64'>			<span class="c1">// if it is found put it to the output</span></div><div class='line' id='LC65'>			<span class="k">if</span><span class="p">(</span><span class="nv">$thispost</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC66'>				<span class="c1">// get permalink by ID.  check wp-includes/wpmu-functions.php</span></div><div class='line' id='LC67'>				<span class="nv">$thispermalink</span> <span class="o">=</span> <span class="nx">get_blog_permalink</span><span class="p">(</span><span class="nv">$blog</span><span class="p">,</span> <span class="nv">$thispost</span><span class="p">[</span><span class="m">0</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">ID</span><span class="p">);</span></div><div class='line' id='LC68'>				<span class="k">if</span> <span class="p">(</span><span class="nv">$titleOnly</span> <span class="o">==</span> <span class="k">false</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC69'>					<span class="k">echo</span> <span class="nv">$begin_wrap</span><span class="o">.</span><span class="s1">&#39;&lt;a href=&quot;&#39;</span></div><div class='line' id='LC70'>					<span class="o">.</span><span class="nv">$options</span><span class="p">[</span><span class="m">0</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">option_value</span><span class="o">.</span><span class="s1">&#39;&quot;&gt;&#39;</span></div><div class='line' id='LC71'>					<span class="o">.</span><span class="nv">$options</span><span class="p">[</span><span class="m">1</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">option_value</span><span class="o">.</span><span class="s1">&#39;&lt;/a&gt;&#39;</span><span class="o">.</span><span class="nv">$end_wrap</span><span class="p">;</span></div><div class='line' id='LC72'>					<span class="nv">$counter</span><span class="o">++</span><span class="p">;</span></div><div class='line' id='LC73'>					<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC74'>						<span class="k">echo</span> <span class="nv">$begin_wrap</span><span class="o">.</span><span class="s1">&#39;&lt;a href=&quot;&#39;</span><span class="o">.</span><span class="nv">$thispermalink</span></div><div class='line' id='LC75'>						<span class="o">.</span><span class="s1">&#39;&quot;&gt;&#39;</span><span class="o">.</span><span class="nv">$thispost</span><span class="p">[</span><span class="m">0</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">post_title</span><span class="o">.</span><span class="s1">&#39;&lt;/a&gt;&#39;</span><span class="o">.</span><span class="nv">$end_wrap</span><span class="p">;</span></div><div class='line' id='LC76'>						<span class="nv">$counter</span><span class="o">++</span><span class="p">;</span></div><div class='line' id='LC77'>					<span class="p">}</span></div><div class='line' id='LC78'>			<span class="p">}</span></div><div class='line' id='LC79'>			<span class="c1">// don&#39;t go over the limit</span></div><div class='line' id='LC80'>			<span class="k">if</span><span class="p">(</span><span class="nv">$counter</span> <span class="o">&gt;=</span> <span class="nv">$how_many</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC81'>				<span class="k">break</span><span class="p">;</span> </div><div class='line' id='LC82'>			<span class="p">}</span></div><div class='line' id='LC83'>		<span class="p">}</span></div><div class='line' id='LC84'>		<span class="k">echo</span> <span class="s2">&quot;&lt;/ul&gt;&quot;</span><span class="p">;</span></div><div class='line' id='LC85'>	<span class="p">}</span></div><div class='line' id='LC86'><span class="p">}</span></div><div class='line' id='LC87'><br/></div><div class='line' id='LC88'><span class="k">function</span> <span class="nf">wpmu_recent_blogs_control</span><span class="p">()</span> <span class="p">{</span></div><div class='line' id='LC89'>	<span class="nv">$options</span> <span class="o">=</span> <span class="nx">get_option</span><span class="p">(</span><span class="s1">&#39;wpmu_recent_blogs_widget&#39;</span><span class="p">);</span></div><div class='line' id='LC90'><br/></div><div class='line' id='LC91'>	<span class="k">if</span> <span class="p">(</span><span class="o">!</span><span class="nb">is_array</span><span class="p">(</span> <span class="nv">$options</span> <span class="p">))</span> <span class="p">{</span></div><div class='line' id='LC92'>		<span class="nv">$options</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span></div><div class='line' id='LC93'>			<span class="s1">&#39;title&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;Last Blogs&#39;</span><span class="p">,</span></div><div class='line' id='LC94'>			<span class="s1">&#39;number&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;10&#39;</span><span class="p">,</span></div><div class='line' id='LC95'>			<span class="s1">&#39;days&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;-1&#39;</span></div><div class='line' id='LC96'>		<span class="p">);</span></div><div class='line' id='LC97'>	<span class="p">}</span></div><div class='line' id='LC98'><br/></div><div class='line' id='LC99'>	<span class="k">if</span> <span class="p">(</span><span class="nv">$_POST</span><span class="p">[</span><span class="s1">&#39;wpmu_recent_blogs_submit&#39;</span><span class="p">])</span> <span class="p">{</span></div><div class='line' id='LC100'>		<span class="nv">$options</span><span class="p">[</span><span class="s1">&#39;title&#39;</span><span class="p">]</span> <span class="o">=</span> <span class="nb">htmlspecialchars</span><span class="p">(</span><span class="nv">$_POST</span><span class="p">[</span><span class="s1">&#39;wpmu_recent_blogs_title&#39;</span><span class="p">]);</span></div><div class='line' id='LC101'>		<span class="nv">$options</span><span class="p">[</span><span class="s1">&#39;number&#39;</span><span class="p">]</span> <span class="o">=</span> <span class="nb">intval</span><span class="p">(</span><span class="nv">$_POST</span><span class="p">[</span><span class="s1">&#39;wpmu_recent_blogs_number&#39;</span><span class="p">]);</span></div><div class='line' id='LC102'>		<span class="nv">$options</span><span class="p">[</span><span class="s1">&#39;days&#39;</span><span class="p">]</span> <span class="o">=</span> <span class="nb">intval</span><span class="p">(</span><span class="nv">$_POST</span><span class="p">[</span><span class="s1">&#39;wpmu_recent_blogs_days&#39;</span><span class="p">]);</span></div><div class='line' id='LC103'>		<span class="nx">update_option</span><span class="p">(</span><span class="s2">&quot;wpmu_recent_blogs_widget&quot;</span><span class="p">,</span> <span class="nv">$options</span><span class="p">);</span></div><div class='line' id='LC104'>	<span class="p">}</span></div><div class='line' id='LC105'><br/></div><div class='line' id='LC106'><span class="cp">?&gt;</span><span class="x"></span></div><div class='line' id='LC107'><br/></div><div class='line' id='LC108'><span class="x">	&lt;p&gt;</span></div><div class='line' id='LC109'><span class="x">	&lt;label for=&quot;wpmu_recent_blogs_title&quot;&gt;Title: &lt;/label&gt;</span></div><div class='line' id='LC110'><span class="x">	&lt;br /&gt;&lt;input type=&quot;text&quot; id=&quot;wpmu_recent_blogs_title&quot; name=&quot;wpmu_recent_blogs_title&quot; value=&quot;</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$options</span><span class="p">[</span><span class="s1">&#39;title&#39;</span><span class="p">];</span><span class="cp">?&gt;</span><span class="x">&quot; /&gt;</span></div><div class='line' id='LC111'><span class="x">	&lt;br /&gt;&lt;label for=&quot;wpmu_recent_blogs_number&quot;&gt;Number of blogs to show: &lt;/label&gt;</span></div><div class='line' id='LC112'><span class="x">	&lt;input type=&quot;text&quot; size=&quot;3&quot; id=&quot;wpmu_recent_blogs_number&quot; name=&quot;wpmu_recent_blogs_number&quot; value=&quot;</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$options</span><span class="p">[</span><span class="s1">&#39;number&#39;</span><span class="p">];</span><span class="cp">?&gt;</span><span class="x">&quot; /&gt;</span></div><div class='line' id='LC113'><span class="x">	&lt;br /&gt;&lt;label for=&quot;wpmu_recent_blogs_days&quot;&gt;Number of days to limit: &lt;/label&gt;</span></div><div class='line' id='LC114'><span class="x">	&lt;input type=&quot;text&quot; size=&quot;3&quot; id=&quot;wpmu_recent_blogs_days&quot; name=&quot;wpmu_recent_blogs_days&quot; value=&quot;</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$options</span><span class="p">[</span><span class="s1">&#39;days&#39;</span><span class="p">];</span><span class="cp">?&gt;</span><span class="x">&quot; /&gt;</span></div><div class='line' id='LC115'><span class="x">	&lt;input type=&quot;hidden&quot; id=&quot;wpmu_recent_blogs_submit&quot; name=&quot;wpmu_recent_blogs_submit&quot; value=&quot;1&quot; /&gt;</span></div><div class='line' id='LC116'><span class="x">	&lt;/p&gt;</span></div><div class='line' id='LC117'><br/></div><div class='line' id='LC118'><span class="cp">&lt;?php</span></div><div class='line' id='LC119'><span class="p">}</span></div><div class='line' id='LC120'><br/></div><div class='line' id='LC121'><span class="k">function</span> <span class="nf">wpmu_recent_blogs_widget</span><span class="p">(</span><span class="nv">$args</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC122'><br/></div><div class='line' id='LC123'>	<span class="nb">extract</span><span class="p">(</span><span class="nv">$args</span><span class="p">);</span></div><div class='line' id='LC124'><br/></div><div class='line' id='LC125'>	<span class="nv">$options</span> <span class="o">=</span> <span class="nx">get_option</span><span class="p">(</span><span class="s2">&quot;wpmu_recent_blogs_widget&quot;</span><span class="p">);</span></div><div class='line' id='LC126'><br/></div><div class='line' id='LC127'>	<span class="k">if</span> <span class="p">(</span><span class="o">!</span><span class="nb">is_array</span><span class="p">(</span> <span class="nv">$options</span> <span class="p">))</span> <span class="p">{</span></div><div class='line' id='LC128'>		<span class="nv">$options</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span></div><div class='line' id='LC129'>			<span class="s1">&#39;title&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;Last Blogs&#39;</span><span class="p">,</span></div><div class='line' id='LC130'>			<span class="s1">&#39;number&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;10&#39;</span><span class="p">,</span></div><div class='line' id='LC131'>			<span class="s1">&#39;days&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;-1&#39;</span></div><div class='line' id='LC132'>		<span class="p">);</span></div><div class='line' id='LC133'>	<span class="p">}</span></div><div class='line' id='LC134'><br/></div><div class='line' id='LC135'>	<span class="k">echo</span> <span class="nv">$before_widget</span><span class="p">;</span></div><div class='line' id='LC136'>	<span class="k">echo</span> <span class="s2">&quot;</span><span class="si">$before_title</span><span class="s2"> </span><span class="si">$options[title]</span><span class="s2"> </span><span class="si">$after_title</span><span class="s2">&quot;</span><span class="p">;</span></div><div class='line' id='LC137'>	<span class="nx">wpmu_recent_blogs_mu</span><span class="p">(</span><span class="nv">$options</span><span class="p">[</span><span class="s1">&#39;number&#39;</span><span class="p">],</span><span class="nv">$options</span><span class="p">[</span><span class="s1">&#39;days&#39;</span><span class="p">],</span><span class="k">false</span><span class="p">,</span><span class="s2">&quot;</span><span class="se">\n</span><span class="s2">&lt;li&gt;&quot;</span><span class="p">,</span><span class="s2">&quot;&lt;/li&gt;&quot;</span><span class="p">);</span></div><div class='line' id='LC138'>	<span class="k">echo</span> <span class="nv">$after_widget</span><span class="p">;</span></div><div class='line' id='LC139'><span class="p">}</span></div><div class='line' id='LC140'><br/></div><div class='line' id='LC141'><span class="k">function</span> <span class="nf">wpmu_recent_blogs_init</span><span class="p">()</span> <span class="p">{</span></div><div class='line' id='LC142'><br/></div><div class='line' id='LC143'>	<span class="c1">// Check for the required API functions</span></div><div class='line' id='LC144'>	<span class="k">if</span> <span class="p">(</span> <span class="o">!</span><span class="nb">function_exists</span><span class="p">(</span><span class="s1">&#39;register_sidebar_widget&#39;</span><span class="p">)</span> <span class="o">||</span> <span class="o">!</span><span class="nb">function_exists</span><span class="p">(</span><span class="s1">&#39;register_widget_control&#39;</span><span class="p">)</span> <span class="p">)</span></div><div class='line' id='LC145'>		<span class="k">return</span><span class="p">;</span></div><div class='line' id='LC146'><br/></div><div class='line' id='LC147'>	<span class="nx">register_sidebar_widget</span><span class="p">(</span><span class="nx">__</span><span class="p">(</span><span class="s2">&quot;WPMU Recent Blogs&quot;</span><span class="p">),</span><span class="s2">&quot;wpmu_recent_blogs_widget&quot;</span><span class="p">);</span></div><div class='line' id='LC148'>	<span class="nx">register_widget_control</span><span class="p">(</span><span class="nx">__</span><span class="p">(</span><span class="s2">&quot;WPMU Recent Blogs&quot;</span><span class="p">),</span><span class="s2">&quot;wpmu_recent_blogs_control&quot;</span><span class="p">);</span></div><div class='line' id='LC149'><span class="p">}</span></div><div class='line' id='LC150'><br/></div><div class='line' id='LC151'><span class="nx">add_action</span><span class="p">(</span><span class="s2">&quot;plugins_loaded&quot;</span><span class="p">,</span><span class="s2">&quot;wpmu_recent_blogs_init&quot;</span><span class="p">);</span></div><div class='line' id='LC152'><span class="cp">?&gt;</span><span class="x"></span></div><div class='line' id='LC153'><br/></div></pre></div>
              
            
          </td>
        </tr>
      </table>
    
  </div>


          </div>
        </div>
      </div>
    </div>
  

  </div>


<div class="frame frame-loading" style="display:none;">
  <img src="https://d3nwyuy0nl342s.cloudfront.net/images/modules/ajax/big_spinner_336699.gif" height="32" width="32">
</div>

    </div>
  
      
    </div>

    <div id="footer" class="clearfix">
      <div class="site">
        <div class="sponsor">
          <a href="http://www.rackspace.com" class="logo">
            <img alt="Dedicated Server" height="36" src="https://d3nwyuy0nl342s.cloudfront.net/images/modules/footer/rackspace_logo.png?v2" width="38" />
          </a>
          Powered by the <a href="http://www.rackspace.com ">Dedicated
          Servers</a> and<br/> <a href="http://www.rackspacecloud.com">Cloud
          Computing</a> of Rackspace Hosting<span>&reg;</span>
        </div>

        <ul class="links">
          <li class="blog"><a href="https://github.com/blog">Blog</a></li>
          <li><a href="/login/multipass?to=http%3A%2F%2Fsupport.github.com">Support</a></li>
          <li><a href="https://github.com/training">Training</a></li>
          <li><a href="http://jobs.github.com">Job Board</a></li>
          <li><a href="http://shop.github.com">Shop</a></li>
          <li><a href="https://github.com/contact">Contact</a></li>
          <li><a href="http://develop.github.com">API</a></li>
          <li><a href="http://status.github.com">Status</a></li>
        </ul>
        <ul class="sosueme">
          <li class="main">&copy; 2011 <span id="_rrt" title="0.67044s from fe6.rs.github.com">GitHub</span> Inc. All rights reserved.</li>
          <li><a href="/site/terms">Terms of Service</a></li>
          <li><a href="/site/privacy">Privacy</a></li>
          <li><a href="https://github.com/security">Security</a></li>
        </ul>
      </div>
    </div><!-- /#footer -->

    
      
      
        <!-- current locale:  -->
        <div class="locales instapaper_ignore readability-footer">
          <div class="site">

            <ul class="choices clearfix limited-locales">
              <li><span class="current">English</span></li>
              
                  <li><a rel="nofollow" href="?locale=de">Deutsch</a></li>
              
                  <li><a rel="nofollow" href="?locale=fr">Français</a></li>
              
                  <li><a rel="nofollow" href="?locale=ja">日本語</a></li>
              
                  <li><a rel="nofollow" href="?locale=pt-BR">Português (BR)</a></li>
              
                  <li><a rel="nofollow" href="?locale=ru">Русский</a></li>
              
                  <li><a rel="nofollow" href="?locale=zh">中文</a></li>
              
              <li class="all"><a href="#" class="minibutton btn-forward js-all-locales"><span><span class="icon"></span>See all available languages</span></a></li>
            </ul>

            <div class="all-locales clearfix">
              <h3>Your current locale selection: <strong>English</strong>. Choose another?</h3>
              
              
                <ul class="choices">
                  
                      <li><a rel="nofollow" href="?locale=en">English</a></li>
                  
                      <li><a rel="nofollow" href="?locale=af">Afrikaans</a></li>
                  
                      <li><a rel="nofollow" href="?locale=ca">Català</a></li>
                  
                      <li><a rel="nofollow" href="?locale=cs">Čeština</a></li>
                  
                      <li><a rel="nofollow" href="?locale=de">Deutsch</a></li>
                  
                </ul>
              
                <ul class="choices">
                  
                      <li><a rel="nofollow" href="?locale=es">Español</a></li>
                  
                      <li><a rel="nofollow" href="?locale=fr">Français</a></li>
                  
                      <li><a rel="nofollow" href="?locale=hr">Hrvatski</a></li>
                  
                      <li><a rel="nofollow" href="?locale=hu">Magyar</a></li>
                  
                      <li><a rel="nofollow" href="?locale=id">Indonesia</a></li>
                  
                </ul>
              
                <ul class="choices">
                  
                      <li><a rel="nofollow" href="?locale=it">Italiano</a></li>
                  
                      <li><a rel="nofollow" href="?locale=ja">日本語</a></li>
                  
                      <li><a rel="nofollow" href="?locale=nl">Nederlands</a></li>
                  
                      <li><a rel="nofollow" href="?locale=no">Norsk</a></li>
                  
                      <li><a rel="nofollow" href="?locale=pl">Polski</a></li>
                  
                </ul>
              
                <ul class="choices">
                  
                      <li><a rel="nofollow" href="?locale=pt-BR">Português (BR)</a></li>
                  
                      <li><a rel="nofollow" href="?locale=ru">Русский</a></li>
                  
                      <li><a rel="nofollow" href="?locale=sr">Српски</a></li>
                  
                      <li><a rel="nofollow" href="?locale=sv">Svenska</a></li>
                  
                      <li><a rel="nofollow" href="?locale=zh">中文</a></li>
                  
                </ul>
              
            </div>

          </div>
          <div class="fade"></div>
        </div>
      
    

    <script>window._auth_token = "9b0b9e794cab0fd5d3394ee62b4c0b5c6bac57c8"</script>
    

<div id="keyboard_shortcuts_pane" class="instapaper_ignore readability-extra" style="display:none">
  <h2>Keyboard Shortcuts <small><a href="#" class="js-see-all-keyboard-shortcuts">(see all)</a></small></h2>

  <div class="columns threecols">
    <div class="column first">
      <h3>Site wide shortcuts</h3>
      <dl class="keyboard-mappings">
        <dt>s</dt>
        <dd>Focus site search</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>?</dt>
        <dd>Bring up this help dialog</dd>
      </dl>
    </div><!-- /.column.first -->

    <div class="column middle" style='display:none'>
      <h3>Commit list</h3>
      <dl class="keyboard-mappings">
        <dt>j</dt>
        <dd>Move selected down</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>k</dt>
        <dd>Move selected up</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>t</dt>
        <dd>Open tree</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>p</dt>
        <dd>Open parent</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>c <em>or</em> o <em>or</em> enter</dt>
        <dd>Open commit</dd>
      </dl>
    </div><!-- /.column.first -->

    <div class="column last" style='display:none'>
      <h3>Pull request list</h3>
      <dl class="keyboard-mappings">
        <dt>j</dt>
        <dd>Move selected down</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>k</dt>
        <dd>Move selected up</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>o <em>or</em> enter</dt>
        <dd>Open issue</dd>
      </dl>
    </div><!-- /.columns.last -->

  </div><!-- /.columns.equacols -->

  <div style='display:none'>
    <div class="rule"></div>

    <h3>Issues</h3>

    <div class="columns threecols">
      <div class="column first">
        <dl class="keyboard-mappings">
          <dt>j</dt>
          <dd>Move selected down</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>k</dt>
          <dd>Move selected up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>x</dt>
          <dd>Toggle select target</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>o <em>or</em> enter</dt>
          <dd>Open issue</dd>
        </dl>
      </div><!-- /.column.first -->
      <div class="column middle">
        <dl class="keyboard-mappings">
          <dt>I</dt>
          <dd>Mark selected as read</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>U</dt>
          <dd>Mark selected as unread</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>e</dt>
          <dd>Close selected</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>y</dt>
          <dd>Remove selected from view</dd>
        </dl>
      </div><!-- /.column.middle -->
      <div class="column last">
        <dl class="keyboard-mappings">
          <dt>c</dt>
          <dd>Create issue</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>l</dt>
          <dd>Create label</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>i</dt>
          <dd>Back to inbox</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>u</dt>
          <dd>Back to issues</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>/</dt>
          <dd>Focus issues search</dd>
        </dl>
      </div>
    </div>
  </div>

  <div style='display:none'>
    <div class="rule"></div>

    <h3>Network Graph</h3>
    <div class="columns equacols">
      <div class="column first">
        <dl class="keyboard-mappings">
          <dt><span class="badmono">←</span> <em>or</em> h</dt>
          <dd>Scroll left</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="badmono">→</span> <em>or</em> l</dt>
          <dd>Scroll right</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="badmono">↑</span> <em>or</em> k</dt>
          <dd>Scroll up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="badmono">↓</span> <em>or</em> j</dt>
          <dd>Scroll down</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>t</dt>
          <dd>Toggle visibility of head labels</dd>
        </dl>
      </div><!-- /.column.first -->
      <div class="column last">
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">←</span> <em>or</em> shift h</dt>
          <dd>Scroll all the way left</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">→</span> <em>or</em> shift l</dt>
          <dd>Scroll all the way right</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">↑</span> <em>or</em> shift k</dt>
          <dd>Scroll all the way up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">↓</span> <em>or</em> shift j</dt>
          <dd>Scroll all the way down</dd>
        </dl>
      </div><!-- /.column.last -->
    </div>
  </div>

  <div >
    <div class="rule"></div>

    <h3>Source Code Browsing</h3>
    <div class="columns threecols">
      <div class="column first">
        <dl class="keyboard-mappings">
          <dt>t</dt>
          <dd>Activates the file finder</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>l</dt>
          <dd>Jump to line</dd>
        </dl>
      </div>
    </div>
  </div>

</div>
    

    <!--[if IE 8]>
    <script type="text/javascript" charset="utf-8">
      $(document.body).addClass("ie8")
    </script>
    <![endif]-->

    <!--[if IE 7]>
    <script type="text/javascript" charset="utf-8">
      $(document.body).addClass("ie7")
    </script>
    <![endif]-->

    
    <script type='text/javascript'></script>
    
  </body>
</html>

