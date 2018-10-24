<?php
/**
 * Template file used to render a Server 404 error page.
 *
 * @package Responsive_Framework
 */

get_header(); ?>
<script type="text/javascript">

(function() {
    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame']
                                   || window[vendors[x]+'CancelRequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function(callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() { callback(currTime + timeToCall); },
              timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };

    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
}());

var Nodes = {

  // Settings
  density: 16,
  drawDistance: 24,
  baseRadius: 4,
  maxLineThickness: 4,
  reactionSensitivity: 3,
  lineThickness: 1,
  points: [],
  mouse: { x: -1000, y: -1000, down: false },
  animation: null,
  canvas: null,
  context: null,
  imageInput: null,
  bgImage: null,
  bgCanvas: null,
  bgContext: null,
  bgContextPixelData: null,

  init: function() {
    // Set up the visual canvas
    this.canvas = document.getElementById( 'canvas' );
    this.context = canvas.getContext( '2d' );
    this.context.globalCompositeOperation = "lighter";
    this.canvas.width = window.innerWidth;
    this.canvas.height = window.innerHeight;
    this.canvas.style.display = 'block'
    this.imageInput = document.createElement( 'input' );
    this.imageInput.setAttribute( 'type', 'file' );
    this.imageInput.style.visibility = 'hidden';
    this.imageInput.addEventListener('change', this.upload, false);
    document.body.appendChild( this.imageInput );
    this.canvas.addEventListener('mousemove', this.mouseMove, false);
    this.canvas.addEventListener('mousedown', this.mouseDown, false);
    this.canvas.addEventListener('mouseup',   this.mouseUp,   false);
    this.canvas.addEventListener('mouseout',  this.mouseOut,  false);

    window.onresize = function(event) {
      Nodes.canvas.width = window.innerWidth;
      Nodes.canvas.height = window.innerHeight;
      Nodes.onWindowResize();
    }

    //Makes the image by using base64
    this.loadData( 'data:image/gif;base64,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');
  },

  preparePoints: function() {

    // Clear the current points
    this.points = [];

    var width, height, i, j;

    var colors = this.bgContextPixelData.data;

    for( i = 0; i < this.canvas.height; i += this.density ) {

      for ( j = 0; j < this.canvas.width; j += this.density ) {

        var pixelPosition = ( j + i * this.bgContextPixelData.width ) * 4;

        // Dont use whiteish pixels
        if ( colors[pixelPosition] > 200 && (colors[pixelPosition + 1]) > 200 && (colors[pixelPosition + 2]) > 200 || colors[pixelPosition + 3] === 0 ) {
          continue;
        }

        var color = 'rgba(' + colors[pixelPosition] + ',' + colors[pixelPosition + 1] + ',' + colors[pixelPosition + 2] + ',' + '1)';
        this.points.push( { x: j, y: i, originalX: j, originalY: i, color: color } );

      }
    }
  },

  updatePoints: function() {

    var i, currentPoint, theta, distance;

    for (i = 0; i < this.points.length; i++ ){

      currentPoint = this.points[i];

      theta = Math.atan2( currentPoint.y - this.mouse.y, currentPoint.x - this.mouse.x);

      if ( this.mouse.down ) {
        distance = this.reactionSensitivity * 400 / Math.sqrt((this.mouse.x - currentPoint.x) * (this.mouse.x - currentPoint.x) +
         (this.mouse.y - currentPoint.y) * (this.mouse.y - currentPoint.y));
      } else {
        distance = this.reactionSensitivity * 200 / Math.sqrt((this.mouse.x - currentPoint.x) * (this.mouse.x - currentPoint.x) +
         (this.mouse.y - currentPoint.y) * (this.mouse.y - currentPoint.y));
      }


      currentPoint.x += Math.cos(theta) * distance + (currentPoint.originalX - currentPoint.x) * 0.05;
      currentPoint.y += Math.sin(theta) * distance + (currentPoint.originalY - currentPoint.y) * 0.05;

    }
  },

  drawLines: function() {

    var i, j, currentPoint, otherPoint, distance, lineThickness;

    for ( i = 0; i < this.points.length; i++ ) {

      currentPoint = this.points[i];

      // Draw the dot.
      this.context.fillStyle = currentPoint.color;
      this.context.strokeStyle = currentPoint.color;

      for ( j = 0; j < this.points.length; j++ ){

        // Distaqnce between two points.
        otherPoint = this.points[j];

        if ( otherPoint == currentPoint ) {
          continue;
        }

        distance = Math.sqrt((otherPoint.x - currentPoint.x) * (otherPoint.x - currentPoint.x) +
         (otherPoint.y - currentPoint.y) * (otherPoint.y - currentPoint.y));

        if (distance <= this.drawDistance) {

          this.context.lineWidth = (1 - (distance / this.drawDistance)) * this.maxLineThickness * this.lineThickness;
          this.context.beginPath();
          this.context.moveTo(currentPoint.x, currentPoint.y);
          this.context.lineTo(otherPoint.x, otherPoint.y);
          this.context.stroke();
        }
      }
    }
  },

  drawPoints: function() {

    var i, currentPoint;

    for ( i = 0; i < this.points.length; i++ ) {

      currentPoint = this.points[i];

      // Draw the dot.
      this.context.fillStyle = currentPoint.color;
      this.context.strokeStyle = currentPoint.color;

      this.context.beginPath();
      this.context.arc(currentPoint.x, currentPoint.y, this.baseRadius ,0 , Math.PI*2, true);
      this.context.closePath();
      this.context.fill();

    }
  },

  draw: function() {
    this.animation = requestAnimationFrame( function(){ Nodes.draw() } );

    this.clear();
    this.updatePoints();
    this.drawLines();
    this.drawPoints();

  },

  clear: function() {
    this.canvas.width = this.canvas.width;
  },

  // The filereader has loaded the image... add it to image object to be drawn
  loadData: function( data ) {

    this.bgImage = new Image;
    this.bgImage.src = data;

    this.bgImage.onload = function() {

      //this
      Nodes.drawImageToBackground();
    }
  },

  // Image is loaded... draw to bg canvas
  drawImageToBackground: function () {

    this.bgCanvas = document.createElement( 'canvas' );
    this.bgCanvas.width = this.canvas.width;
    this.bgCanvas.height = this.canvas.height;

    var newWidth, newHeight;

    // If the image is too big for the screen... scale it down.
    if ( this.bgImage.width > this.bgCanvas.width - 100 || this.bgImage.height > this.bgCanvas.height - 100) {

      var maxRatio = Math.max( this.bgImage.width / (this.bgCanvas.width - 100) , this.bgImage.height / (this.bgCanvas.height - 100) );
      newWidth = this.bgImage.width / maxRatio;
      newHeight = this.bgImage.height / maxRatio;

    } else {
      newWidth = this.bgImage.width;
      newHeight = this.bgImage.height;
    }

    // Draw to background canvas
    this.bgContext = this.bgCanvas.getContext( '2d' );
    this.bgContext.drawImage( this.bgImage, (this.canvas.width - newWidth) / 2, (this.canvas.height - newHeight) / 2, newWidth, newHeight);
    this.bgContextPixelData = this.bgContext.getImageData( 0, 0, this.bgCanvas.width, this.bgCanvas.height );

    this.preparePoints();
    this.draw();
  },

  mouseDown: function( event ){
    Nodes.mouse.down = true;
  },

  mouseUp: function( event ){
    Nodes.mouse.down = false;
  },

  mouseMove: function(event){
    Nodes.mouse.x = event.offsetX || (event.layerX - Nodes.canvas.offsetLeft);
    Nodes.mouse.y = event.offsetY || (event.layerY - Nodes.canvas.offsetTop);
  },

  mouseOut: function(event){
    Nodes.mouse.x = -1000;
    Nodes.mouse.y = -1000;
    Nodes.mouse.down = false;
  },

  // Resize and redraw the canvas.
  onWindowResize: function() {
    cancelAnimationFrame( this.animation );
    this.drawImageToBackground();
  }
}

  setTimeout( function() {
    Nodes.init();
}, 10 );

</script>
<div class="error-404 not-found content-area">

	<header class="page-header">
		<?php responsive_the_title(); ?>
		<div id="page-not-found-banner-container">
			<canvas id='canvas' class="page-not-found-banner"  height="200px">
				<img src="/andrew/files/2018/05/page-not-found-interactive-banner.png">
			</canvas>
		</div>
	</header><!-- .page-header -->

	<div class="page-content">
		<p><?php esc_html_e( 'Looks like that page might not be here anymore. Want to give search a try?', 'responsive-framework' ); ?></p>

		<?php responsive_search_form(); ?>

	</div><!-- .page-content -->
</div><!-- .error-404 -->

<?php
get_footer();