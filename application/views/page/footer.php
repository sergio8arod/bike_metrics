      </div> <!-- container -->
      
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.2/knockout-min.js"></script> 
    
    <!-- Custom script for this template -->
    <?php if(isset($scripts)):?>
        <?php foreach($scripts as $script):?>
            <script src="<?php echo $script;?>"></script>
        <?php endforeach;?>
    <?php endif;?>
    <script src="<?php echo base_url('js/welcome_message.js');?>"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?php echo base_url('js/ie10-viewport-bug-workaround.js');?>" rel="stylesheet"
          
    <!-- PHP-driven JavaScript Utility Functions --> 
    <script> 
        function base_url(params) { 
            return '<?php echo base_url(); ?>' + params;
        }
        function site_url(params) {
            return '<?php echo site_url(); ?>' + '/' + params;
        }
    </script>
  </body>
</html>