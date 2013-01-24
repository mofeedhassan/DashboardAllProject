<!DOCTYPE HTML>
<html>
<head>
 <!-- CSS dependencies -->
<link type="text/css" rel="stylesheet" href="css/bootstrap.css">

</head>
<body>

<?php  
$dbhost = 'localhost';  
$dbuser = 'root';  
$dbpass = 'mofo';  
$dbname = 'QADashhold';  
$dbtable = 'InterlinkingInformation';  

//------ DATABASE CONNECTION --------//  
mysql_connect($dbhost,$dbuser,$dbpass)  or die ("Unable to connect to database");  
echo "Connected to MySQl <br>";
////////////////////////////////
mysql_select_db($dbname)  or die ("Unable to select database");
echo "Connected to Database <br>";
///////////////////////////////////
$sql = "SELECT * FROM $dbtable";  
$result = mysql_query($sql) or die ("Unable to execute query");
echo "Selection is done <br>";
/////////////////////////////////////
$number=mysql_numrows($result); 
echo $number;
while($row = mysql_fetch_array($result))
  {
	  print $row['Source'] . " " . $row['Target'];
	  print "<br />";
	  echo"<script language='javascript'>\n"; 
	  echo"myarray = new Array($number-1);\n";
	  while ($i < $number)  
		{  
			$text = mysql_result($result, $i, "name");  
			print "$text";  
			echo"myarray[$i]=$text;"; 
			$i++;  
		}  
	   
		echo"\n</script>"; 
  }
?>
<!------------------------------------------------------------------>
<div id="header">
    <img src="img/AKSW_Logo.png" >
    <img src="img/latc-logo.gif" >
</div>
<div class="well well-large">
<p align="justify">
<b>
This page presents a linksets inventory as an addition to Quality Assurrance Dashboard. The data of the linkset inventory are derived from the Linkset API 
(http://linker.sindice.com/runtime-results/). <br>
The provided information include:  link-set,source dataset,target dataset,interlinnking	type,number of triples, and downloads.In downloads the specifications and links files
for the link-set are accessed
</b>
</p>
</div>

<br>
<form id="linksTablesfrm2" class="well span20" >
	<div id= "linksTablesdiv" class="span3">
		<table id="tbll" class="table table-bordered table-hover tablesorter">
			<thead>
				<tr>
					<th>File name</th>
					<th>Source</th>
					<th>Target</th>
					<th>Type</th>
					<th>Number of triples</th>
					<th>Downloads</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
<!--	<input id="btnsort" type="button" value ="Sort "  class="btn btn-primary"/>"-->

</form> 
<br>
<form  class="well span20" >
<input id="output" name="name" size="15" type="text" />.	
</form> 
<input type="file" onchange="readSingleFile(this)" />


 <!-- JS dependencies -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.fileDownload.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script
<script type="text/javascript" src="js/jquery-latest.js"></script>


 <script type="text/javascript">
 $(document).ready(function() {
		    //for creating dynamic table
		   

			$('#tbll').fixheadertable({ 
				height     : 200, 
				zebra      : true,
				zebraClass : 'ui-state-active' // default
			});
			$('btnsort').click(function() {
					$("#tbll").tablesorter({sortList: [[0,0], [1,0]]}); 
			});
			////////////////////////////////////
			$.ajax({
			type: "GET",
			url: "note.xml",
			dataType: "xml",
			success: function(xml) { parseXml(xml); }
		  }) ;
			
		});// The end of document load function
 // This function creates dynamically a table with the specified number of rows and columns
  	function createDynamicTable(tbody, rows, cols) {
           if (tbody == null || tbody.length < 1) return; //check number of rows and columns
           for (var r = 1; r <= rows; r++) { //for each row
               var trow = $("<tr class=\"info\">");	//create row open tag
               var lblele=$("<label id="+cellText+">1</label>");	//create inside it a label with id equals the specified text
               for (var c = 1; c < cols; c++) 
               {
                   var cellText = contents + r + "." + c
                   $("<td>").addClass("tableCell").text(cellText).data("col", c).appendTo(trow); //put a text inside the cell
                  // lblele.appendTo($("<td>").appendTo(trow));
               }
               var cellText = "Cell " + r + "." + cols;//specify the column where the button will be created
               var btnele=$("<input type=\"button\" value =\"links \"  class=\"btn btn-primary\"  onClick=\"window.location.href='http://www.goldcoastwebdesigns.com/dl/aff-masters.zip'\"/>"+
               "  <input type=\"button\" value =\"Specs \"  class=\"btn btn-primary\"  onClick=\"window.location.href='http://www.goldcoastwebdesigns.com/dl/aff-masters.zip'\"/>");
               btnele.appendTo($("<td>").appendTo(trow));
              trow.appendTo(tbody);
          }
      }  
      
      function parseXml(xml)
		{
		  //find every Tutorial and print the author
		  $(xml).find("Tutorial").each(function()
		  {
			$("#output").appendTo($(this).attr("author") + "<br />");
		  });

		  // Output:
		  // The Reddest
		  // The Hairiest
		  // The Tallest
		  // The Fattest
		}

		var reader = new FileReader();

		function readText(that){

			if(that.files && that.files[0]){
				var reader = new FileReader();
				reader.onload = function (e) {  
					var output=e.target.result;
				
					//process text to show only lines with "@":				
					output=output.split("\n").filter(/./.test, /\@/).join("\n");

					document.getElementById('main').innerHTML= output;
				};//end onload()
				reader.readAsText(that.files[0]);
			}//end if html5 filelist support
		} 
		var contents;
		function readSingleFile(evt) {
				//Retrieve the first (and only!) File from the FileList object
				var f = evt.target.files[0]; 

				if (f) {
				  var r = new FileReader();
				  r.onload = function(e) { 
					contents = e.target.result;
					alert( "Got the file.n" 
						  +"name: " + f.name + "n"
						  +"type: " + f.type + "n"
						  +"size: " + f.size + " bytesn"
						  + "starts with: " + contents.substr(1, contents.indexOf("n"))
					);  
					//document.write(contents);
				  }
				  r.readAsText(f);
				} else { 
				  alert("Failed to load file");
				}
			}
 
</script>
</body>
</html>
