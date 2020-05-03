</span></div>


<script src="http://www.thermofisher.com.au/scripts/jquery-1.8.3.min.js" type="text/javascript"></script>
<script>
  // make relative links full path (except when image exists locally)
  $(document).ready(function(){
    var country = $('#country').val();
    var baseURL;
    var img;
    if(country == "Australia"){
      baseURL = "http://www.thermofisher.com.au";
    }
    else if(country == "New Zealand"){
      baseURL = "http://www.thermofisher.co.nz";
    }
    function imageExists(url, callback) {
      var img = new Image();
      img.onload = function() { callback(true); };
      img.onerror = function() { callback(false); };
      img.src = url;
    }
    $("#PageContent img").each(function(){
      var img = $(this);
      var img_src = img.attr('src');
      
      imageExists(img_src, function(exists) {
        
        if(exists == false){
          console.log("Can't find image " + img_src);
          
          if (img_src && !img_src.match(/^http([s]?):\/\/.*/)) {
            img.attr('src', baseURL + img_src);
            console.log(img.attr('src'));
          }
        }
        else{
          console.log("Image Exists" . img_src);
        }
     
      });
      
    });

    $("#PageContent a").each(function(){
      var link = $(this).attr('href');
      if (link && !link.match(/^http([s]?):\/\/.*/)) {
        if(!$(this).hasClass('local')){
          $(this).attr('href', baseURL + link);
        }
        
      }
    });
  });
</script>



<!-- page content  -->
  			
  			</div> <!-- main -->
  			
            <!--side--> 
            <div id="side"> 
                

              
                    <div class="quicklinks">
                  <h3>Resources</h3>
                    <ul id="bl_QuickLinks">
    <li><a href="/ContentAUS/Environmental-Industrial/Useful-Quick-Links.html">Useful associations and other links</a></li><li><a href="/content/Top-Menu/MSDS-CofA-TGA.html">SDS, CoA &amp; TGA Search/Request</a></li>
  </ul>
                </div>
                
                
                
                

                
                <div class="news">
                  <h3>Literature</h3>
                    <ul id="bl_News">
    <li><a href="/Uploads/file/Environmental-Industrial/Industry-Focus_Environmental_low-res.pdf">Environmental Capabilities Brochure</a></li><li><a href="/Uploads/file/Environmental-Industrial/1426563641-EIP-Product-PortfolioCR-2.pdf">Environmental &amp; Industrial Process Product Portfolio</a></li>
  </ul>
                </div>
                    
                    
          
            </div>
            <!--side-->

            
        </div>
        <!--Content-->

<textarea maxlength="255"></textarea>
        
	</div>

    
</div>
    
    

    <input name="hd_mode" type="hidden" id="hd_mode" />
    <input type="hidden"  id="submit_search" name="submit_search" />
        
 </form> <!-- formMain end -->
 
  <!-- Bottom Menu -->   
      <div id="Div1">    
        

 <div class="verticalspacer"></div>
    <div class="clearfix colelem" id="pu1948"><!-- group -->
     <div class="gradient browser_width grpelem" id="u1948"><!-- group -->
      <div class="clearfix" id="u1948_align_to_page">
       <div class="clearfix grpelem" id="pu2438-6"><!-- column -->
        <div class="clearfix colelem" id="u2438-6"><!-- content -->
         <p id="u2438-2">Connect</p>
         <p id="u2438-3">&nbsp;</p>
         <p id="u2438-4">&nbsp;</p>
        </div>
        <div class="clearfix colelem" id="u2485-5"><!-- content -->
         <p><span id="u2485">We want to hear from you. So do your colleagues in the scientific community. Together, we can find a solution.</span></p>
        </div>
       </div>
       <div class="grpelem" id="u2427"><!-- simple frame --></div>
       <div class="clearfix grpelem" id="u2420-43"><!-- content -->
        <p id="u2420-2">Products</p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Healthcare/Clinical-Diagnostic-Testing-Products/Clinical-Diagnostic-Testing-Products.html">Clinical Diagnostic Testing</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Healthcare/Medical-Instrumentation/Diagnostic-Imaging/diagnostic-imaging.html">Diagnostic Imaging</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Environmental-Industrial/Environmental-Monitoring-Safety/Environmental-Monitoring-Safety.html">Environmental Monitoring</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Healthcare/Medical-Devices-Consumables/Medical-Devices-Consumables.html">Healthcare Consumables</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Environmental-Industrial/Process-Monitoring-Industrial-Instruments/Process-Monitoring-Industrial-Instruments.html">Industrial &amp; Process</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Scientific/Laboratory-Chemicals/Laboratory-Chemicals.html">Laboratory Chemicals</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Scientific/Laboratory-Equipment-Furniture/Laboratory-Equipment-Furniture.html">Laboratory Equipment</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Scientific/Laboratory-Plasticware-Glassware-Supplies/Laboratory-Plasticware-Glassware-Supplies.html">Laboratory Supplies</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Scientific/Life-Science-Research-Technologies/Life-Science-Research-Technologies.html">Life Science Research</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Healthcare/Medical-Devices-Consumables/Medical-Devices-Consumables.html">Medical Devices</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Scientific/Microbiology-Products/Microbiology-Products.html">Microbiology Products</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Healthcare/Pathology-Equipment-Supplies/Pathology-Equipment-Supplies.html">Pathology Supplies</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Scientific/Scientific-Instruments-Automation/Scientific-Instruments-Automation.html">Scientific Instruments</a></p>
       </div>
       <div class="grpelem" id="u2426"><!-- simple frame --></div>
       <div class="clearfix grpelem" id="u2421-41"><!-- content -->
        <p id="u2421-2">Services</p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Top-Menu/Service-And-Calibration/Service-And-Calibration.html">Service &amp; Calibration</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/content/Top-Menu/Rentals/Rentals.html">Rentals</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Top-Menu/Applications/Equipment-Financing.html">Financial and Leasing Services</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/content/Top-Menu/Demo-Facility/Demo-Facility.html">Demonstration Facility</a></p>
        <p id="u2421-17"><a class="nonblock" href="/ContentAUS/Scientific/LIMS-Laboratory-Software/LIMS-Laboratory-Software.html">LIMS &amp; Lab Software</a></p>
        <p id="u2421-18">&nbsp;</p>
        <p id="u2421-20">Resources</p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Promotions/Promotions.html">Promotions</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Top-Menu/Catalogues.html">Brochures &amp; Catalogues</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/content/Top-Menu/SDS-CofA-TGA.html">SDS / CoA Search</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Top-Menu/Application-Notes.html">Application Notes</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Top-Menu/Training-Webinars-Videos.html">Training, Videos &amp; Webinars</a></p>
        <p id="u2421-37">&nbsp;</p>
        <p id="u2421-38">&nbsp;</p>
        <p>&nbsp;</p>
       </div>
       <div class="grpelem" id="u2425"><!-- simple frame --></div>
       <div class="clearfix grpelem" id="u2422-21"><!-- content -->
        <p id="u2422-2">About Us</p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Top-Menu/Tradeshows-Conferences.html">Trade Shows &amp; Events</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/contentAUS/Top-Menu/Brands-We-Represent/Brands-We-Represent.html">Brands We Represent</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Top-Menu/About-Us/Our-History/Our-History.html">Our History</a></p>
        <p class="Footer-Links"><a class="nonblock" href="/ContentAUS/Top-Menu/About-Us/Careers/Careers.html">Careers at Thermo Fisher</a></p>
        <p id="u2422-18">&nbsp;</p>
        <p>&nbsp;</p>
       </div>
      </div>
     </div>
     <div class="gradient browser_width grpelem" id="u2675"><!-- group -->
      <div class="clearfix" id="u2675_align_to_page">
       <div class="clip_frame grpelem" id="u2431"><!-- image -->
        <img class="block" id="u2431_img" src="http://www.thermofisher.com.au/images/au.png" alt="" width="24" height="18"/>
       </div>
       <div class="clearfix grpelem" id="u2423-19"><!-- content -->
        <p><span id="u2423">&nbsp;Australia&nbsp;&nbsp;&nbsp; |&nbsp; </span>&nbsp; <a class="nonblock" href="/ContentAUS/Top-Menu/Footer/Terms-And-Conditions-Australia.html" target="_blank" title="Terms and Conditions">Terms and Conditions</a>&nbsp;&nbsp; |&nbsp;&nbsp; <a class="nonblock" href="/ContentAUS/Top-Menu/Footer/Privacy-Policy-Australia.html">Privacy Statement</a>&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp; <a class="nonblock" href="http://www.thermofisher.com/" target="_blank" title="Visit our Corporate Site&nbsp; ">Visit our corporate site</a><span title="Visit our Corporate Site&nbsp; ">&nbsp;</span>&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp; <a class="nonblock" href="/ContentAUS/Top-Menu/About-Us/Careers/Careers.html">Careers At Thermo Fisher Scientific </a>&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp; <span id="u2423-16">© Copyright 2015 Thermo Fisher Scientific Inc. All Rights Reserved.</span></p>
       </div>
      </div>
     </div>
     <a class="nonblock nontext clip_frame grpelem" id="u2468" href="https://www.facebook.com/thermofisher" target="_blank" title="Facebook"><!-- image --><img class="block" id="u2468_img" src="http://www.thermofisher.com.au/images/facebook.png" alt="Facebook" width="32" height="32"/></a>
     <a class="nonblock nontext clip_frame grpelem" id="u2473" href="https://twitter.com/servingscience" target="_blank" title="Twitter"><!-- image --><img class="block" id="u2473_img" src="http://www.thermofisher.com.au/images/twitter.png" alt="" width="32" height="32"/></a>
     <a class="nonblock nontext clip_frame grpelem" id="u2478" href="http://www.linkedin.com/company/thermo-fisher-scientific-anz" target="_blank" title="Linked&#45;In"><!-- image --><img class="block" id="u2478_img" src="http://www.thermofisher.com.au/images/linkedin.png" alt="" width="32" height="32"/></a>
     <a class="nonblock nontext clip_frame grpelem" id="u2483" href="https://www.youtube.com/user/thermoscientific2" target="_blank" title="You Tube"><!-- image --><img class="block" id="u2483_img" src="http://www.thermofisher.com.au/images/youtube-3-xl.png" alt="" width="32" height="32"/></a>
     <a class="nonblock nontext clip_frame grpelem" id="u2495" href="http://acceleratingscience.com/" target="_blank" title="Accelerating Science Blog"><!-- image --><img class="block" id="u2495_img" src="http://www.thermofisher.com.au/images/blogger.png" alt="" width="32" height="32"/></a>
    </div>
   </div>
  </div>
  <div class="preload_images">
   <img class="preload" src="http://www.thermofisher.com.au/images/search-icon_rollover.png" alt=""/>
   <img class="preload" src="http://www.thermofisher.com.au/images/sub-menu-arrow.png" alt=""/>
   <img class="preload" src="http://www.thermofisher.com.au/images/u1688-17-r.png" alt=""/>
   <img class="preload" src="http://www.thermofisher.com.au/images/u1688-17-m.png" alt=""/>
   <img class="preload" src="http://www.thermofisher.com.au/images/u1688-17-fs.png" alt=""/>
   <img class="preload" src="http://www.thermofisher.com.au/images/menu-arrow_right.png" alt=""/>
   <img class="preload" src="http://www.thermofisher.com.au/images/menu-arrow.png" alt=""/>
  </div> 
    </div>    
  
   <!-- Contact Us -->
    <div id="Div2">    
        

<!-- START SCRIPT ContactUS tab -->

<script src="http://www.thermofisher.com.au/scripts/jquery-1.8.3.min.js" type="text/javascript"></script>


 
	
<script type="text/javascript">
$(document).ready(function(){
  





	$(".trigger").click(function(){
		$(".panel").toggle("fast");
		$(this).toggleClass("active");
		return false;
	});
});
</script>

 <div class="panel">
	 <form id="form1" >
    
    
    <div>
          <h2>Contact Us</h2>                  
            <table>
                <tr>
                    <td>
                        <input  id="name" maxlength="80" required="required" name="name" type="text" placeholder="Contact Name"/>
                        <br/><br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input  id="email" maxlength="80" name="email" type="text" placeholder="Email"/>                     
                        <br/><br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input  id="phone" maxlength="40" name="phone" type="text" placeholder="Phone"/><br/><br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input  id="company" maxlength="80" name="company" type="text" placeholder="Company"/><br/><br/>
                    </td>
                </tr>
               
                <tr>
                    <td>
                        <select  id="selRequestType" name="selRequestType" title="Enquiry Type">
                            <option value="none">Enquiry type...</option>
                            <option value="Request Information">Request Information</option>
                            <option value="Request for Quote">Request for Quote</option>
                            
                            <option value="Customer Feedback">Customer Feedback</option>
                            <option value="Other">Other</option>
                        </select><br/><br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <textarea name="message" id="message" placeholder="Add a brief message..."></textarea><br/><br/>
                    </td>
                </tr>
                                
                <tr>
                    <td>
                    <table width="100%">
                        <tr>
                            <td width="35%"><div id="captchaimg" ></div></td>
                            
                         </tr>
                    </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" id="txt_code" Placeholder="Please enter the numbers above"/><br /><br />
                    </td>
                </tr>
                <tr>
                    <td>
                        
                        <input type="submit" name="submit" value="" onclick="return validateForm()"/>
                    </td>
                </tr>
                
            </table>

        
        <input type="hidden" id="captchacode" />
        <input type="hidden" id="originURL" />
        <script type="text/javascript">document.getElementById('originURL').value = window.location.href;</script>
    </div>
    </form>

</div>

<!-- Sliding out button -->
<a class="trigger" href="#">Contact Us</a>

<!-- Validate email address format -->
<script>
  
</script>
<script type="text/javascript">

    //Load the captcha code
  $(document).ready(function() {

      

            $.ajax({
                type: "POST",
                url: "/WebServiceGD/CaptchaService.asmx/Generate",
                dataType: "xml",
                success: function(data) {
                    $("#captchaimg").html(data.documentElement.textContent);
                    var html = $.parseHTML(data.documentElement.textContent);
                    $("#captchacode").val($(html)[1].defaultValue);
                }
            });
        })

    //Click to reload Captcha
        function reloadcaptcha(){
             $.ajax({
                type: "POST",
                url: "/WebServiceGD/CaptchaService.asmx/Generate",
                dataType: "xml",
                success: function(data) {
                    $("#captchaimg").html(data.documentElement.textContent);
                    var html = $.parseHTML(data.documentElement.textContent);
                    $("#captchacode").val($(html)[1].defaultValue);
                }
            });
        }
        
        
   //Check if captcha is correct 
       function CaptchaIsCorrect() {
            $.ajax({
                type: "POST",
                url: "/WebServiceGD/CaptchaService.asmx/CodeIsCorrect",
                data: "typedCode=" + $("#txt_code").val() + "&CaptchaEncoded=" + $("#captchacode").val(),
                dataType: "xml",
                  success: function(data) {
                    var html = $.parseHTML(data.documentElement.textContent);
                    if (html[0].textContent == "false")
                        {
                            alert("The 6 digit numbers you've entered is incorrect. Please try again!");
                            reloadcaptcha();
                        }
                    else
                        {
//                            alert("Capture is correct");
                            submitRequest();
                        }
                }
            });
            
            return false;
        }
            

                


    //If everything is okay. Submit the form
          function submitRequest() {
//            alert("URL="+"typedCode=" + $("#txt_code").val() + "&CaptchaEncoded=" + $("#captchacode").val() +
//                    "&name=" + $("#name").val() +
//                    "&email=" + $("#email").val() +
//                    "&phone=" + $("#phone").val() +
//                    "&company=" + $("#company").val() +
//                    "&selRequestType=" + $("#selRequestType").val() +
//                    "&message=" + $("#message").val());
//                    return;
                    
            $.ajax({
                type: "POST",
                url: "/WebServiceGD/CaptchaService.asmx/SubmitRequest",
                data: "typedCode=" + $("#txt_code").val() + "&CaptchaEncoded=" + $("#captchacode").val() +
                    "&Name=" + $("#name").val() +
                    "&Email=" + $("#email").val() +
                    "&Phone=" + $("#phone").val() +
                    "&Company=" + $("#company").val() +
                    "&selRequestType=" + $("#selRequestType").val() +
                    "&message=" + $("#message").val() +
                    "&originURL=" + $("#originURL").val() +
					"&ProductCodeWeb=",     
                    
                dataType: "xml",
                success: function(data) {
                    var html = $.parseHTML(data.documentElement.textContent);
                    if (html[0].textContent == "")
                        {
                            alert("Your request failed to submit. Please try again in a few minutes.");
                        }
                    else 
                        {
                            alert("Your request has been submitted!");
                            location.reload(); 
                        }
                    }
            });

            return false;
        }


        
     
     //Validation rules for the whole form
         function validateForm()
            { 
                
                  var vname =  document.forms['form1']['name'].value;
                  var vemail = document.forms['form1']['email'].value;
                  var vcompany = document.forms['form1']['company'].value;
                  var vmessage = document.forms['form1']['message'].value;
                  var vdropdown = document.forms['form1']['selRequestType'].value;
                  var vcaptchafield = document.forms['form1']['txt_code'].value;
                  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                                   
                  $(".error").hide();
                  var hasError = false; 
                    
                  if(vname == '') 
                        {
                            $("#name").after('<span class="error"><br />Please enter your name.</span>');
                            return false;
                        }                        
                   else if(vemail == '') 
                        {
                            $("#email").after('<span class="error"><br />Please enter your email address.</span>');
                            return false;
                        }
                    else if(!emailReg.test(vemail)) 
                        {
                            $("#email").after('<span class="error"><br />Enter a valid email address.</span>');
                            return false;
                        }
                    else if(vcompany == '') 
                        {
                            $("#company").after('<span class="error"><br />Please enter your company name.</span>');
                            return false;
                        }
                    else if(vdropdown == 'none') 
                        {
                            $("#selRequestType").after('<span class="error"><br />Please select an enquiry type.</span>');
                            return false;
                        }
                    else if(vmessage == '') 
                        {
                            $("#message").after('<span class="error"><br />Please enter a brief message of your enquiry.</span>');
                            return false;
                        }    
                    else if(vcaptchafield == '') 
                        {
                            $("#txt_code").after('<span class="error"><br />Please enter the 6 digit numbers above.</span>');
                            return false;
                        }
                    else {
                            CaptchaIsCorrect();
                         }
                return false;
            }
            
           
 </script>       
    </div> 
   
  
  

 <!-- AU JavaCodes -->
    <div>
        



<!-- JS includes -->
  <script type="text/javascript">
      if (document.location.protocol != 'https:') document.write('\x3Cscript src="http://musecdn.businesscatalyst.com/scripts/4.0/jquery-1.8.3.min.js" type="text/javascript">\x3C/script>');
</script>
  <script type="text/javascript">
      window.jQuery || document.write('\x3Cscript src="scripts/jquery-1.8.3.min.js" type="text/javascript">\x3C/script>');
</script>
  <script src="http://www.thermofisher.com.au/scripts/museutils.js" type="text/javascript"></script>
  <script src="http://www.thermofisher.com.au/scripts/jquery.tobrowserwidth.js" type="text/javascript"></script>
  <script src="http://www.thermofisher.com.au/scripts/jquery.musemenu.js" type="text/javascript"></script>
  <script src="http://www.thermofisher.com.au/scripts/webpro.js" type="text/javascript"></script>
  <script src="http://www.thermofisher.com.au/scripts/musewpslideshow.js" type="text/javascript"></script>
  <script src="http://www.thermofisher.com.au/scripts/jquery.museoverlay.js" type="text/javascript"></script>
  <script src="http://www.thermofisher.com.au/scripts/touchswipe.js" type="text/javascript"></script>
  <script src="http://www.thermofisher.com.au/scripts/jquery.musepolyfill.bgsize.js" type="text/javascript"></script>
  <script src="http://www.thermofisher.com.au/scripts/jquery.watch.js" type="text/javascript"></script>
  <script src="http://www.thermofisher.com.au/scripts/jquery.tobrowserwidth.js" type="text/javascript"></script>
  <script src="http://www.thermofisher.com.au/scripts/musewpdisclosure.js" type="text/javascript"></script>
  <script src="http://www.thermofisher.com.au/scripts/tmo-tabs.js" type="text/javascript"></script>

<script>
  $(document).ready(function(){


  });

</script>
  
  <!-- Other scripts -->
  <script type="text/javascript">
      $(document).ready(function() {
          try {
              Muse.Utils.transformMarkupToFixBrowserProblemsPreInit(); /* body */
              $('.browser_width').toBrowserWidth(); /* browser width elements */
              Muse.Utils.prepHyperlinks(true); /* body */
              Muse.Utils.initWidget('.MenuBar', function(elem) { return $(elem).museMenu(); }); /* unifiedNavBar */
              Muse.Utils.initWidget('#widgetu1673', function(elem) { new WebPro.Widget.Form(elem, { validationEvent: 'submit', errorStateSensitivity: 'high', fieldWrapperClass: 'fld-grp', formSubmittedClass: 'frm-sub-st', formErrorClass: 'frm-subm-err-st', formDeliveredClass: 'frm-subm-ok-st', notEmptyClass: 'non-empty-st', focusClass: 'focus-st', invalidClass: 'fld-err-st', requiredClass: 'fld-err-st', ajaxSubmit: true }); }); /* #widgetu1673 */
              Muse.Utils.initWidget('#slideshowu1397', function(elem) { $(elem).data('widget', new WebPro.Widget.ContentSlideShow(elem, { autoPlay: true, displayInterval: 3000, slideLinkStopsSlideShow: false, transitionStyle: 'fading', lightboxEnabled_runtime: false, shuffle: false, transitionDuration: 500, enableSwipe: true, fullScreen: false })); }); /* #slideshowu1397 */
              Muse.Utils.initWidget('#pamphletu1385', function(elem) { new WebPro.Widget.ContentSlideShow(elem, { contentLayout_runtime: 'stack', event: 'mouseover', deactivationEvent: 'mouseout_both', autoPlay: false, displayInterval: 3000, transitionStyle: 'fading', transitionDuration: 500, hideAllContentsFirst: true, shuffle: false, enableSwipe: true }); }); /* #pamphletu1385 */
              Muse.Utils.initWidget('#pamphletu208', function(elem) { new WebPro.Widget.ContentSlideShow(elem, { contentLayout_runtime: 'stack', event: 'click', deactivationEvent: 'none', autoPlay: true, displayInterval: 3500, transitionStyle: 'horizontal', transitionDuration: 500, hideAllContentsFirst: false, shuffle: false, enableSwipe: false }); }); /* #pamphletu208 */
              /*Muse.Utils.initWidget('#pamphletu1005', function(elem) { new WebPro.Widget.ContentSlideShow(elem, { contentLayout_runtime: 'stack', event: 'click', deactivationEvent: 'none', autoPlay: false, displayInterval: 3000, transitionStyle: 'fading', transitionDuration: 500, hideAllContentsFirst: false, shuffle: false, enableSwipe: true }); });*/ /* #pamphletu1005 */
              
              Muse.Utils.fullPage('#page'); /* 100% height page */
              Muse.Utils.showWidgetsWhenReady(); /* body */
              Muse.Utils.transformMarkupToFixBrowserProblems(); /* body */
          } catch (e) { Muse.Assert.fail('Error calling selector function:' + e); } 
      });
</script>

  <script type="text/javascript">
   $(document).ready(function() { try {
Muse.Utils.transformMarkupToFixBrowserProblemsPreInit();/* body */
Muse.Utils.prepHyperlinks(true);/* body */
Muse.Utils.initWidget('#accordionu14775', function(elem) { return new WebPro.Widget.Accordion(elem, {canCloseAll:true,defaultIndex:-1}); });/* #accordionu14775 */
Muse.Utils.fullPage('#page');/* 100% height page */
Muse.Utils.showWidgetsWhenReady();/* body */
Muse.Utils.transformMarkupToFixBrowserProblems();/* body */
} catch(e) { Muse.Assert.fail('Error calling selector function:' + e); }});
</script>  

<!-- Show Hide sample item numbers -->
<script type="text/javascript">
// Hide all the elements in the DOM that have a class of "box"
$('.box').hide();

// Make sure all the elements with a class of "clickme" are visible and bound
// with a click event to toggle the "box" state
$('.clickme').each(function() {
    $(this).show(0).on('click', function(e) {
        // This is only needed if your using an anchor to target the "box" elements
        e.preventDefault();
        
        // Find the next "box" element in the DOM
        $(this).next('.box').slideToggle('fast');
    });
});
</script>

   
 
<script src="http://www.thermofisher.com.au/scripts/jquery-ui-DatePicker.js"></script>

    <script type="text/javascript">
        $(function () {
            $("#datepicker").datepicker();
        });
    </script> 



    </div>
    
   
</body>
</html>