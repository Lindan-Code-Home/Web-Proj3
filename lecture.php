

<html>
<head>
<title> Weather Search </title>
<script language=javascript>
function checkinput()
{
var location=document.getElementById("location").value;
var search_type=document.getElementById("type").options[document.getElementById("type").selectedIndex].value;

  if (location=="")
  {alert("please enter a location!");
  return false;}
  if(search_type=="Zip")
   { if (!/^\d{5}$/.test(location))
      {alert("please enter a valid 5-digt Zip code!");
       return false;}
    }
   
	if(search_type=="city")
	{ if (/^\d{1,}$/.test(location))
      {alert("please enter a valid City name! Cannot be all digits!");
       	return false;}
    }
	
	if(search_type=="city")
	{ if (/_+/.test(location))
      {alert("please enter a valid City name! Cannot be include underscore!");
       	return false;}
    }
	 //alert("first is right!");
     //return false;}
   //if((search_type==ture)&&(if (!/^\d{5}$/.test(location))))
 //{alert("please enter a valid Zip code!"); 
 // return false;}

}



</script>

<style type="text/css">
body {
       margin-top:120px;
      }
h1{ font-size:32px;}
form{height:200px;
     width:400px;
     border:double;
      text-align:center;}

</style>

</head>

<body>
<center>
<h1> Weather Search </h1>

<form method="post"  action="" >

<?php if (isset($_POST["submit"])):?> 
        
<p style="float:left;margin-left:5px;"> Location: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input id="location"  name="location" type=text value="<?php echo htmlspecialchars($_POST['location']); ?>" style="width=100px;"/> </p> <br/>

<?php else:?>
<p style="float:left;margin-left:5px;"> Location: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input id="location"  name="location" type=text  style="width=100px;"/> </p> <br/>
<?php endif; ?>

<?php if ((isset($_POST["submit"]))&&($_POST["type"]=="Zip")):?> 
<p style="float:left;margin-left:5px;margin-top:5px">Location Type:&nbsp&nbsp 
<select id= "type" name="type" style="width:140px;" >
<option value="city" > City </option>
<option id="Zip" value="Zip" selected> Zip Code</option>
</select></p>
<?php else:?>
<p style="float:left;margin-left:5px;margin-top:5px">Location Type:&nbsp&nbsp  
<select id= "type" name="type" style="width:140px;" >
<option value="city" selected> City </option>
<option id="Zip" value="Zip"> Zip Code</option>
</select></p>
<?php endif; ?>

<?php if ((isset($_POST["submit"]))&&($_POST["unit"]=="C")):?>
<p style="float:left;margin-left:5px;margin-top:5px">Temperature Unit: &nbsp <input type=radio name=unit value="F" >Fahrenheit&nbsp&nbsp <input type=radio name=unit value="C" checked >Celsius 

<?php else :?>
<p style="float:left;margin-left:5px;margin-top:5px">Temperature Unit: &nbsp <input type=radio name=unit value="F" checked>Fahrenheit&nbsp&nbsp <input type=radio name=unit value="C" >Celsius 

<?php endif; ?>


<br/><br/>

<input style="text-aligh:center" type=submit onClick="return checkinput()" name="submit" value="Search"> </input>
</form>
</center>


 <?php 
   if(isset($_POST["submit"])) 
       {$location= $_POST["location"];
	    $type= $_POST["type"];
		$unit=$_POST["unit"];
		//Print $type;
        if($type=="Zip")
		{$url="http://where.yahooapis.com/v1/concordance/usps/".$location."?appid=<e9bm1v_V34G3bYv77JucPG8VLk4mOHDtko4wzMNDnJgwokNVM4Zsi68ulky.Jt.EJg-->";
		//header("Location: $url");
		//$xml=simplexml_load_file($url);
		
		//echo $xml->woeid;
		//$woeid=$xml->woeid;
		
		
		}
		
		else if($type=="city")
		{//$location_new=urlencode($location);
		//$location=preg_replace('/\s/','+',$location);
		//$location=preg_replace('/\s/','+',$location);
		//$url="http://where.yahooapis.com/v1/places\$and(.q('".$location."'),.type(7));start=0;count=5?appid=[e9bm1v_V34G3bYv77JucPG8VLk4mOHDtko4wzMNDnJgwokNVM4Zsi68ulky.Jt.EJg--]";

          //$xml=simplexml_load_file($url);
		 
		   //$city=preg_replace('/\s/','+',$location);
		   $location_org=$location;
		   $location=urlencode($location);
		   $url="http://where.yahooapis.com/v1/places\$and(.q('".$location."'),.type(7));start=0;count=5?appid=[e9bm1v_V34G3bYv77JucPG8VLk4mOHDtko4wzMNDnJgwokNVM4Zsi68ulky.Jt.EJg--]";
		   
		 
		 //header("Location: $url");
		 
          
         }
        		
           $content = @file_get_contents($url);
		   
		   if($content==false)
		   {
      		 echo "<p align=center><b>Zero Results Found!</b></p>";
		     return 0;
		   }
           
		   $match_result=preg_match_all('/<woeid>(\d+)<\/woeid>/',$content,$woeid,PREG_PATTERN_ORDER);
		   if(!$match_result)
		   {echo "<p align=center><b>Zero Results Found!</b></p>";
				   return 0;
		   }
		   
		   
		   
		   $flag=0;
		   //for counting beging
		   for($i = 0; $i < count($woeid[1]);$i++)
		   
		   {  if($unit=="F")	
		       $new_url="http://weather.yahooapis.com/forecastrss?w=".$woeid[1][$i]."&u=f";
			    
			   
			   else
			   $new_url="http://weather.yahooapis.com/forecastrss?w=".$woeid[1][$i]."&u=c";	
			   
			   $xml=simplexml_load_file($new_url);
			   if($xml->channel->title=="Yahoo! Weather - Error")
			   continue;
			    $flag++;
			}
				if($flag>=0)
				{ if($type=="Zip")
				  {echo "<p align=center>" .$flag. " result for zip code ".$location."</p> ";}
				  else if($type=="city")
				  {echo "<p align=center>" .$flag. " result(s) for City ".$location_org."</p> ";}
	            } 	
				else if($flag==0)
				   echo "<p align=center><b>Zero Results Found!</b></p>" ;
			//for counting end
			$flag=0;//Reset the flag value
		   for($i = 0; $i < count($woeid[1]);$i++)
		   
		   {  if($unit=="F")	
		       $new_url="http://weather.yahooapis.com/forecastrss?w=".$woeid[1][$i]."&u=f";
			    
			   
			   else
			   $new_url="http://weather.yahooapis.com/forecastrss?w=".$woeid[1][$i]."&u=c";	
			   
			   $xml=simplexml_load_file($new_url);
			   if($xml->channel->title=="Yahoo! Weather - Error")
			   continue;
			    $flag++;
				if($flag==1)
          		{
 				  echo "<div align = middle><table align = center border=double width = 60%>\n";
		echo "<tr aligh = center><th>Weather</th><th>Temperature</th><th>City</th><th>Region</th><th>Country</th><th>Latitude</th><th>Logitude</th><th>Link to Details</th></tr>\n";}
				preg_match_all('/src="(.*?)"/',$xml->channel->item->description,$image,PREG_PATTERN_ORDER);
			  //$src=$xml->channel->item->description->children(img)->attribute()->src;
			  $temp_cond=$xml->channel->item->children('yweather',true)->condition->attributes()->text;
			  if($temp_cond==""&&$image[1][0]=="")
			  echo "<td align=center>N/A</td>";
			  
			  else
			  echo "<tr><td align=center><a target=_blank\" href=$new_url><img title=\"".$temp_cond."\"  alt=\"".$temp_cond."\" src=\"".$image[1][0]."\" ></image></a></td>";
			  
			  //echo "<tr><td align=center><a target=_blank\" href=$new_url><img title=\"".$temp_cond."\"  alt=\"".$temp_cond."\" src=\"".$src."\" ></image></a></td>";
			  //echo "<tr><td align=center><a target=_blank\" href=$new_url><img alt=\"".$temp_cond."\" src=\""."\" ></image></a></td>";
					  
					    //$temp_cond=$xml->channel->item->children('yweather',true)->condition->attributes()->text;
					    $temp_value=$xml->channel->item->children('yweather',true)->condition->attributes()->temp;
					    $temp_unit=$xml->channel->children('yweather',true)->units->attributes()->temperature;
		      
			  if($temp_cond==""&&$temp_value==""&&$temp_unit=="")
              echo "<td align=center>N/A</td>";
			  else
			  echo "<td align=center>".$temp_cond."&nbsp".$temp_value."&deg".$temp_unit."</td>";
			  
			  
			  $city_out=$xml->channel->children('yweather',true)->location->attributes()->city;
			  if($city_out=="")
			  echo "<td align=center>N/A</td>";
			  else
			  echo "<td align=center>".$city_out."</td>";
			  
			  $region_out=$xml->channel->children('yweather',true)->location->attributes()->region;
			  if($region_out=="")
			  echo "<td align=center>N/A</td>";
			  else
			  echo "<td align=center>".$region_out."</td>";
			  
			  $country_out=$xml->channel->children('yweather',true)->location->attributes()->country;
			  if($country_out=="")
			  echo "<td align=center>N/A</td>";
			  else
			  echo "<td align=center>".$country_out."</td>";
	         	   
              $lat_out=$xml->channel->item->children('geo',true)->lat;
			  if($lat_out=="")
			  echo "<td align=center>N/A</td>";
			  else
			  echo "<td align=center>".$lat_out."</td>";
			  
			  $long_out=$xml->channel->item->children('geo',true)->long;
			  if($long_out=="")
			  echo "<td align=center>N/A</td>";
			  else
			  echo "<td align=center>".$long_out."</td>";
			  
			  $link_out=$xml->channel->link;
			   if($link_out=="")
			  echo "<td align=center>N/A</td>";
			  else
			  echo "<td align=center><a target=_blank href=$link_out>Details</td></tr>";
			  	   

		   }
					 

        }
       
 ?>
</body>
</html>