 <?php 
    require 'header.php';
?>
 <script>
	 // Attach a click handler
	$('.addValue').click(tallyValues);
 	// The function that tallies the checked values
	function tallyValues(){
		
		// Set the amount to start at 0
		var amount = 0;
		
		// Loop through each dom element
		$('table .num').each(function(i, val){
			
			// Find the previous sibling (td) and then find the input inside and see if it's checked
			var checkbox_cell_is_checked = $(this).prev().find('input').is(':checked');
			
			// Is it checked?
			if(checkbox_cell_is_checked){
				amount += parseInt($(this).text())
			}
			
		});
		
		// Output the amount
		alert(amount);
		
	}
 
 </script>
 
 
 <form>
 <table>
 <tr>
      <th>ADD </th>
      <th>Value </th>
  <tr>
     <td><input type="checkbox" name="check_data"></td>
      <td class="num"> 2 </td>
  </tr>
  <tr>
     <td><input type="checkbox" name="check_data"></td>
      <td class="num"> 3 </td>
  </tr>
 <tr>
     <td><input type="checkbox" name="check_data"></td>
      <td class="num"> 4 </td>
  </tr>
  <tr>
    <input type="submit" name="addValues" class="addValue" >
  </tr>
</table>

</form>