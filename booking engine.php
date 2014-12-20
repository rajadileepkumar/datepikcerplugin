<?php
/*
*Plugin Name:Hs Booking engine
*Description:Hs Booking Engine
*Version:1.0
*Author:Dileep
*
*/

define('WP_DEBUG', true);

register_activation_hook(__FILE__,'hs-activate-booking-engine');  
register_deactivation_hook(__FILE__,'hs-deactivation-booking-engine');


add_action('init','hs_load_script');

function hs_load_script()
{
	//wp_enqueue_script('jquery','http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');
	//wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
	echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
';
	echo '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>';
	
	echo '<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/redmond/jquery-ui.min.css" />';
	?>
		<script type="text/javascript">
				

			$(function() {

  
  $( "#sd" ).datepicker({ 
      dateFormat: "dd/mm/yy", 
      //minDate: +1,
      showOn: "button", 
      buttonImage: "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif", 
      buttonImageOnly: true,
      showAnim:"slide",
      changeMonth:true,
      changeYear:true,
      beforeShow: function(){
        // this gets today's date       
        //var theDate = new Date();
        //theDate.setDate(<?php echo $checkin ?> + 2);
                // set min date as 2 days from today
        //$(this).datepicker('option','minDate',theDate);         
      },
          // When datepicker for start date closes run this function
      onClose: function(){
        // this gets the selected start date        
        //var theDate = new Date($(this).datepicker('getDate'));
        // this sets "theDate" 1 day forward of start date
        //theDate.setDate(theDate.getDate() + 1);
        // set min date for the end date as one day after start date
        //$('#ed').datepicker('option','minDate',theDate);
      }
    });
  //$("#sd").datepicker("show");

    $('#ed').datepicker({
      dateFormat: "dd/mm/yy",
      showOn: "button", 
      buttonImage: "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif", 
      buttonImageOnly: true,
      showAnim:"slide",
      beforeShow: function(){
        // this gets today's date       
        var theDate = new Date($( "#sd" ).datepicker('getDate'));
        // sets "theDate" 2 days ahead of today
        theDate.setDate(theDate.getDate() + 1);
        // set min date as 2 days from today
        $(this).datepicker('option','minDate',theDate);         
      },
      onClose:function(){

      }  

    });   
  
  //$("#sd").datepicker("setDate", "<?php echo isset($_POST["check_in"]) ? $_POST["check_in"] : '0' ?>");
  //$("#ed").datepicker("setDate", "<?php echo isset($_POST["check_in"]) ? $_POST["check_out"] : '1' ?>");

 
});

		</script>

    <script type="text/javascript">
      function loadCalender(calendarType)
      {
        //alert(calendarType);

        var xmlHttpObj;

        

        if(window.XMLHttpRequest)

        {

          //code for IE 6+,Mozilla,Safari,Chrome,Opera

          xmlHttpObj = new XMLHttpRequest();

        }

        else

        {

          //Code for IE 5,IE6

          xmlHttpObj = new ActiveXObject("Microsoft.XMLHTTP");

        }

        

        //Receiving Http Response

        xmlHttpObj.onreadystatechange = function()

        {

          if((xmlHttpObj.readyState == 4) && (xmlHttpObj.status == 200))

          {

            document.getElementById("divCal").innerHTML = xmlHttpObj.responseText;

          }

        }

        

        //Generating Http Request

        xmlHttpObj.open("GET","../inc/getCalendar.php?calendarType="+calendarType,true);

        xmlHttpObj.send();//Request will send the server
      }
    </script>
    
		<style type="text/css">
			.cal
			{
				font-family: Arial, Helvetica, Sans-serif; font-size:13px;
				border-radius: 15px;
				width: 500px;
				border: 1px solid #ccc;
				margin-top: 20px;
			}

			img.ui-datepicker-trigger {
         		 position: relative;
          		left: -23px;
          		top: 3px;
    			}
    		
    		.cal form
    		{
    			padding: 20px;
    		}
    		.cal .check-in
    		{
    			display: block;
    			padding: 0;
    			margin: 0;
    		}

    		.cal .check-out
    		{
    			display: block;
    			padding: 0;
    			margin: 0;
    		}

    		.cal .check-in input[type="text"]
    		{
    			padding: 8px;
    			margin-bottom: 15px
    		}

    		.cal .check-out input[type="text"]
    		{
    			padding: 8px;
    			margin-bottom: 15px
    		}

    		.cal .check-in label
    		{
    			padding: 15px;
    			width: 115px;
    			
    		}

    		.cal .check-out label
    		{
    			padding: 15px;
    			width: 115px;
    			float: left;
    		}

    		.cal form button
    		{
    			margin: 15px;
    			margin-left: 105px;
    		}

		</style>
	<?php
}

add_action('admin_menu','hs_booking_menu');

function hs_booking_menu()
{
	add_menu_page('Booking Engine','Booking Engine','manage_options','hs-booking-engine','hs_booking_calender',plugins_url('hs-booking engine/images/calendar.gif'),99);
}



function hs_booking_calender()
{
	global $title;
	?>
		<div class="cal" id="divCal">
			
			<form action="http://www.google.com" method="post" id="cal-from">
				<?php echo $title;?>
				
				<div class="check-in">
					<label>From Date:</label><input type="text" id="sd" value="<?php _e('check-in Date');?>"/>
				</div>

				<div class="check-out">
					<label>To Date:</label><input type="text" id="ed" value="<?php _e('check-out Date');?>"/><br/>
				</div>
          <label>Select Location:</label>
          <select name="country" id="country" onchange="setStates();">
              <option value="Alleppey">Alleppey</option>
              <option value="Kumarakom">Kumarakom</option>
              <option value="Kollam">Kollam</option>
              <option value="Cochin">Cochin</option>
        </select>

          <br/>
          <select name="state" id="state" onchange="setCities();">
            <option value="">Please select a Country</option>
          </select>
          <select name="city"  id="city">
            <option value="">Please select a Country</option>
          </select>

              
           
				<button>SUBMIT</button>
			</form>
		</div>
    <script type="text/javascript">
      var states = new Array();

      states['Alleppey'] = new Array('House Boat-Deluxe','House Boat-Premium Columbia','House Boat-Luxury','Shikara','Motor Boat','Speed Boat ');
      states['Kumarakom'] = new Array('House Boat-Deluxe','House Boat-Premium','House Boat-Luxury');
      states['Kollam'] = new Array('House Boat-Deluxe');
      states['Cochin']=new Array('House Boat-Deluxe ','Other Boat ');


      // City lists
      var cities = new Array();

      cities['Alleppey'] = new Array();
      cities['Alleppey']['House Boat-Deluxe'] = new Array('1Bed','2 Bed','3 Bed','5 Bed');
      cities['Alleppey']['House Boat-Premium Columbia'] = new Array('1Bed','2 Bed','3 Bed','5 Bed');

      cities['Alleppey']['House Boat-Luxury']          = new Array('1Bed','2 Bed','3 Bed','5 Bed');
      //cities['Alleppey']['Speed Boat']=new Array();

      cities['Kumarakom'] = new Array();
      cities['Kumarakom']['House Boat-Deluxe'] = new Array('1Bed','2 Bed','3 Bed','5 Bed');
      cities['Kumarakom']['House Boat-Premium']       = new Array('1Bed','2 Bed','3 Bed','5 Bed');
      cities['Kumarakom']['House Boat-Luxury']         = new Array('1Bed','2 Bed','3 Bed','5 Bed');

      cities['Kollam'] = new Array();
      cities['Kollam']['House Boat-Deluxe'] = new Array('Any');

      cities['Cochin']=new Array();
      cities['Cochin']['House Boat-Deluxe']    = new Array('Any');
      cities['Cochin']['Other Boat']   = new Array('Any');


      function setStates() {
        cntrySel = document.getElementById('country');
        stateList = states[cntrySel.value];
        changeSelect('state', stateList, stateList);
        setCities();
      }

      function setCities() {
        cntrySel = document.getElementById('country');
        stateSel = document.getElementById('state');
        cityList = cities[cntrySel.value][stateSel.value];
        changeSelect('city', cityList, cityList);
      }

      function changeSelect(fieldID, newOptions, newValues) {
        selectField = document.getElementById(fieldID);
        selectField.options.length = 0;
        for (i=0; i<newOptions.length; i++) {
          selectField.options[selectField.length] = new Option(newOptions[i], newValues[i]);
        }
      }

      // Multiple onload function created by: Simon Willison
      // http://simonwillison.net/2004/May/26/addLoadEvent/
      function addLoadEvent(func) {
        var oldonload = window.onload;
        if (typeof window.onload != 'function') {
          window.onload = func;
        } else {
          window.onload = function() {
            if (oldonload) {
              oldonload();
            }
            func();
          }
        }
      }

      addLoadEvent(function() {
        setStates();
      });

    </script>
    
  <?php 
}

function hs_shortcode()
{
	ob_start();
	hs_booking_calender();
	return ob_get_clean();
}

add_shortcode('hs_calender_shortcode','hs_shortcode');


?>
