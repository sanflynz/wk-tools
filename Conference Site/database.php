<?php 
include("includes/db.php");
    include("includes/header_" . $_SESSION['environment'] . ".php"); ?>

    <div class="row">
        <div class="col-md-8 col-xs-12">
            <h2>Contact Form</h2>
            <br>
        </div>
        <div class="col-md-4 col-xs-12">
            <br>
            
        </div>
    </div>
   
        
        <form method="post" name="ANZ_Conference_NZIFST_2016" id="form2092" action="https://s642.t.eloqua.com/e/f2" role="form" class="form-horizontal">
            <input value="ANZ_Conference_NZIFST_2016" type="hidden" name="elqFormName"  />
            <input value="642" type="hidden" name="elqSiteId"  />
            <input name="elqCampaignId" type="hidden"  />

            <input id="field11" type="hidden" name="Event" value="NZIFST 2016" />
                    
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label for="" class="col-sm-3 control-label">First Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-xlarge" id="field2" name="firstName" required>
                            <span class="glyphicon glyphicon-star form-control-feedback" aria-hidden="true" style="color: red;"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label for="" class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-9">
                             <input type="text" class="form-control input-xlarge" id="field3" name="lastName" required>
                            <span class="glyphicon glyphicon-star form-control-feedback" aria-hidden="true" style="color: red;"></span>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Department/Lab</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-xlarge" id="field8" name="department1" >
                        </div>
                        
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label for="" class="col-sm-3 control-label">Job Role</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-xlarge" id="field7" name="jobTitle1" required>
                            <span class="glyphicon glyphicon-star form-control-feedback" aria-hidden="true" style="color: red;"></span>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label for="" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control input-xlarge" id="field4" name="emailAddress" required>
                            <span class="glyphicon glyphicon-star form-control-feedback" aria-hidden="true" style="color: red;"></span>
                        </div>
                        
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Phone</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-xlarge" id="field5" name="busPhone" >
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label for="" class="col-sm-3 control-label">Company</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-xlarge" id="field6" name="company" value="" required>
                            <span class="glyphicon glyphicon-star form-control-feedback" aria-hidden="true" style="color: red;"></span>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-6">
                    
                </div> 
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Street/PO Box</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-xlarge" id="field9" name="address1" value="">
                        </div>
                        
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Suburb</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-xlarge" id="field10" name="address2" value="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label for="" class="col-sm-3 control-label">Town/City</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-xlarge" id="field11" name="city" value="" required>
                            <span class="glyphicon glyphicon-star form-control-feedback" aria-hidden="true" style="color: red;"></span>
                        </div>
                        
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label for="" class="col-sm-3 control-label">State</label>
                        <div class="col-sm-9">
                            
                            <select id="field12" class="form-control" name="stateProv" >
                                <option></option>
                                <option value="NSW">NSW</option>
                                <option value="QLD">QLD</option>
                                <option value="SA">SA</option>
                                <option value="WA">WA</option>
                                <option value="VIC">VIC</option>
                                <option value="TAS">TAS</option>
                                <option value="NT">NT</option>
                                <option value="ACT">ACT</option>
                            </select>
                            <span class="glyphicon glyphicon-star form-control-feedback" aria-hidden="true" style="color: orange;"></span>

                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Post Code</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-xlarge" id="field13" name="zipPostal" value="">
                        </div>
                        
                    </div>
                </div>
                
                 <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label for="" class="col-sm-3 control-label">Country</label>
                        <div class="col-sm-9">
                            <select id="field14" class="form-control" name="country" required>
                                <option></option>
                                <option value="Australia" >Australia</option>
                                <option value="New Zealand" selected>New Zealand</option>
                                <!-- NEED TO ADD PACIFIC EXPORT COUNTRIES TOO -->
                            </select>

                            <span class="glyphicon glyphicon-star form-control-feedback" aria-hidden="true" style="color: red;"></span>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <hr>
                    <h3>Areas of Interest</h3>
                </div>
            </div>
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <label class="checkbox" style="padding-left: 20px;">
                            <input type="checkbox" name="Pathogen_Testing"> Pathogen Testing</label>
                        <label class="checkbox" style="padding-left: 20px;">
                                <input type="checkbox" name="Allergen_Testing"> Allergen Testing</label>
                        <label class="checkbox" style="padding-left: 20px;">
                                <input type="checkbox" name="Spoilage_Organisms"> Spoilage Organisms</label>
                        <label class="checkbox" style="padding-left: 20px;">
                                <input type="checkbox" name="Environmental_Hygiene_Monitoring"> Environmental &amp; Hygiene Monitoring</label>
                    </div>

                    <div class="col-md-4 col-xs-12">
                        <label class="checkbox" style="padding-left: 20px;">
                            <input type="checkbox" name="Chromatography_Mass_Spec"> Chromatography &amp; Mass Spec</label>
                        <label class="checkbox" style="padding-left: 20px;">
                                <input type="checkbox" name="Viscosity"> Viscosity</label>
                        <label class="checkbox" style="padding-left: 20px;">
                                <input type="checkbox" name="Colour_Measurement"> Colour Measurement</label>
                        <label class="checkbox" style="padding-left: 20px;">
                                <input type="checkbox" name="Refraction_Index_Optical_Rotation"> Refraction Index/Optical Rotation</label>
                    </div>

                    <div class="col-md-4 col-xs-12">
                        <label class="checkbox" style="padding-left: 20px;">
                            <input type="checkbox" name="Food_Authenticity"> Food Authenticity</label>
                        <label class="checkbox" style="padding-left: 20px;">
                                <input type="checkbox" name="Product_Inspection"> Product Inspection</label>
                        <label class="checkbox" style="padding-left: 20px;">
                                <input type="checkbox" name="Remote_Data_Aquisition"> Remote Data Aquisition</label>
                        <label class="checkbox" style="padding-left: 20px;">
                                <input type="checkbox" name="Plant_Maintenance_Productivity"> Plant Maintenance & Productivity</label>
                    </div>
                    
                </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h3>Notes</h3>
                            <textarea id="field35" class="form-control" name="Notes" rows="5" style="width: 100%;"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <br>
                            <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                        <div class="col-md-5">
                            <br>
                            <button type="reset" class="btn btn-primary">Reset Form</button>
                        </div>
                        <div class="col-md-3" style="text-align: right;">
                            <br>
                            <!--<input type="text" class="form-control input-mini" id="field14" name="Staff" placeholder="Staff" required oninvalid="this.setCustomValidity('Please ask one of our staff to fill this field')"> -->

                            <select id="field34" class="form-control" name="Staff" required>
                                <option value=""></option>
                                <option value="cheryl.mccormick@thermofisher.com">Cheryl McCormick</option>
                                <option value="henare.ngata@thermofisher.com">Henare Ngata</option>
                                <option value="john.harvey@thermofisher.com">John Harvey</option>
                                <option value="melanie.mccamish@thermofisher.com">Melanie McCamish</option>
                                <option value="sandie.fry@thermofisher.com">Sandie Fry</option>
                                <option value="tracey.smith@thermofisher.com">Tracey Smith</option>
                                <option value="">-------------</option>
                                <option value="eMarketingANZ@thermofisher.com">Other/None</option>

                            </select>
                        </div>
                        
                    </div>
                    
                </form>
        
    

        <script type="text/javascript" src="http://img.en25.com/Web/ThermoFisherScientificLPG/{c492adcb-8096-4896-8066-ce60a823c2ec}_jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script><!-- Validation CDN -->

        <script type="text/javascript">
            <!-- Form validation for safari/iOS -->
            //$("#form1999").validate();
    
            $("#form2092").validate({
                errorElement: "div",
                rules: {
                    emailAddress: {
                        required: true,
                        email: true
                    },
                    stateProv: {
                        required: function(element){
                            return $("#field14").val() == 'Australia'
                        }
                    }
                }   
            });

            
</script>

<?php include("includes/footer_" . $_SESSION['environment'] . ".php"); ?>
