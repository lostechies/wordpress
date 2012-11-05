(function($){

  $.ajaxSetup({
    timeout: 8000
  });

  var Hostess, Task, un;

  Hostess = function( options ){
    
    var defaultOptions = {
      title : 'Hostess',
      beforeMessage : 'Processing. Please wait.',
      successMessage : 'All tasks are completed.',
      failMessage : 'Something went wrong.'
    };
    
    this.options = $.extend( defaultOptions, options );
    this.init();
    
  }
  
  Hostess.prototype = {
    
    tasks : [],
    
    init : function(){
      
      var that = this;
      
      if ( this.$overlay == un ){
        var overlay = $( '#hostess-overlay' );
        if ( ! overlay.length ) {
          this.$overlay = $( "<div id='hostess-overlay'/>" );
          $( document.body ).append( this.$overlay );
        };
      }

      $(document.body).append(this.$overlay);


      this.$dialog = $( "<div class='hostess-dialog'/>" );
      this.$dialog.html( "<h2>" + this.options.title + "</h2><p class='before-msg'>" + this.options.beforeMessage + "</p><div class='canvas'></div></h2>" );

      this.$overlay.append( this.$dialog );

      this.$canvas = $( '.canvas', this.$dialog );

      this.$btn = $("<a class='button'>Ok</a>").hide();
      this.$btn.click(function(e){
        e.preventDefault();
        that.close();
      });

      this.$dialog.append( this.$btn );
      
    },
    
    show: function(){
      this.$overlay.css({display:'block'});
      return this;
    },
    
    addTask : function( title, url, success, error ){
      this.tasks.push( new Task({
        title : title,
        url: url,
        before : success,
        error: error,
        canvas : this.$canvas,
        hostess : this
      }));
      return this;
    },
    
    run : function(){
      this.pointer = 0;
      this.next();
      return this;
    },
    
    next : function(){
      if ( this.tasks[this.pointer] ) {
        this.tasks[this.pointer].run();
        this.pointer++;
      }else{
        this.end();
      }
    },
    
    end : function(){
      var that = this;
      this.$canvas.append("<p class='finished-msg'>"+this.options.successMessage+"</p>");
      this.$btn.show();
      this.$dialog.addClass('ta-da');
      setTimeout(function(){
        that.close()
      },3000);
    },
    
    fail : function(){
      this.$canvas.append("<p class='fail-msg'>"+this.options.failMessage+"</p>");
      this.$btn.show();
    },
    
    close : function(){
      this.$overlay.hide();
    }
    
    
  }
  
  Task = function( options ){

    $.extend( this, options );
    
    this.$ = $('<p class="hostess-task"/>');
    this.$icon = $('<span class="icon"/>');
    this.canvas.append( this.$ );

    this.canvas.append( this.$iframe );

  }
  
  Task.prototype = {
    
    failMsg : '',
    
    run : function(){

      var that = this;

      this.render();

      $.ajax({
        url:this.url,
        dataType:'text'
      })
      .success(function(){
        that.$icon.html('&#10003;').addClass('ok');
        that.hostess.next();
      })
      .error(function(xhr, err){
        that.$icon.html('&#10007;').addClass('not-ok');
        that.hostess.fail();  
      });

    },
    
    render : function(){
      this.$.html( this.title );
      this.$.append( this.$icon  );
      this.$icon.html("…");
    }
    
  }
  
  window.Hostess = Hostess;

})(jQuery);