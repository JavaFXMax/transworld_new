</div>

    <!-- /#wrapper -->

    <!-- Core Scripts - Include with every page -->
  
    {{ HTML::script('js/sb-admin.js') }}

    <!-- Page-Level Demo Scripts - Blank - Use for reference -->

    
    {{ HTML::script('js/bootstrap.min.js') }}

    {{ HTML::script('js/plugins/metisMenu/jquery.metisMenu.js') }}

    <script type="text/javascript">

	$(document).ready(function(){
  		$('.lang').click(function(){

  		var language = $('#language :selected').val();

  		var base_url = '{{ URL::to('languages/') }}';

		//var language = $('#lang').val();
    		$.ajax({
      		url: base_url + language,
      		type: "get",
      		success: function(data){
        		alert(data);
      		},
      		error: function(){
      			alert('error');
      		}

    		});      
  		}); 

	});

</script>


</body>

</html>
