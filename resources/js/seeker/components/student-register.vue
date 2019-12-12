<template>
    <form>
        <div class="col-md-2 col-sm-4 col-xs-12">
            <div class="form-group institutesDropdown_slider">
                <label for="sel1" class="white_text">Institute Type:</label>
                <select class="form-control" id="drpInstituteType" name="institute_type" required="">
                    <option >Private</option>
                    <option >Public</option>
                </select>
            </div>
        </div>

        <div class="col-md-2 col-sm-4 col-xs-12">
            <div class="form-group institutesDropdown_slider">
                <label for="sel1" class="white_text">Institute Name:</label>
                <input type="text" name="institute_name" id="institute_name">
            </div>
        </div>

        <div class="col-md-3 col-sm-4 col-xs-12">
            <div class="form-group institutesDropdown_slider">
                <label for="sel1" class="white_text">Nature of Courses</label>
                <select class="form-control" id="drpNatureofcourse" name="course_name" required="">
                    <option >B. Pharma + MBA (Integrated)</option>
                    <option >B.A + L.L B</option>
                    <option >B.B.A. + L.L.B.</option>
                    <option >B.Com + LLB (Hons. Integrated)</option>
                    <option >B.Tech + M.Tech (Integrated)</option>
                    <option >B.Tech + MBA (Integrated)</option>
                    <option >BA + LLB (Hons. Integrated)</option>
                    <option >BA + LLB (Integrated)</option>
                    <option >Bachelor in Clinical Optometry (B.Optom.)</option>
                    <option >Bachelor in Multimedia Communication(BMMC)</option>
                    <option >Bachelor of Architecture (B.Arch)</option>
                    <option >Bachelor of Arts (BA - 3 Continent)</option>
                    <option >Bachelor of Arts (BA)</option>
                    <option >Bachelor of Arts (Honors)</option>
                    <option >Bachelor of Business Administration (BBA)</option>
                    <option >Bachelor of Business Administration (BBA) (Honors)</option>
                    <option >Bachelor of Commerce (B.Com)</option>
                    <option >Bachelor of Commerce (Honors)</option>
                    <option >Bachelor of Computer Application (BCA - Evening)</option>
                    <option >Bachelor of Computer Application (BCA)</option>
                    <option >Bachelor of Design (B.Des)</option>
                    <option >Bachelor of Education (B.Ed)</option>
                    <option >Bachelor of Engineering (B.E.)</option>
                    <option >Bachelor of Environment Management (BEM)</option>
                    <option >Bachelor of Fashion Technology (BFT)</option>
                    <option >Bachelor of Fine Arts (BFA)</option>
                    <option >Bachelor of Hotel Management</option>
                    <option >Bachelor of Hotel Management &amp; Catering Technology (BHM &amp; CT)</option>
                    <option >Bachelor of Interior Design</option>
                    <option >Bachelor of Law (LLB)</option>
                    <option >Bachelor of Library and Information Science (BLIS)</option>
                    <option >Bachelor of Management Studies (BMS)</option>
                    <option >Bachelor of Occupational Therapy</option>
                    <option >Bachelor of Pharmacy (B.Pharm)</option>
                    <option >Bachelor of Physical Education &amp; Sports</option>
                    <option >Bachelor of Physiotherapy</option>
                    <option >Bachelor of Planning</option>
                    <option >Bachelor of Public Health</option>
                    <option >Bachelor of Science (B.Sc)</option>
                    <option >Bachelor of Science (Honors)</option>
                    <option >Bachelor of Social Work (BSW)</option>
                    <option >Bachelor of Statistics</option>
                    <option >Bachelor of Technology (B.Tech)</option>
                    <option >Bachelor of Vocation (B.Voc.)</option>
                    <option >BBA + LLB  (Integrated)</option>
                    <option >BBA + LLB (Hons. Integrated)</option>
                    <option >BBA + MBA (Integrated)</option>
                    <option >BCA + MCA (Intergrated)</option>
                    <option >BSC + MSC (Intergrated)</option>
                    <option >Diploma</option>
                    <option >Doctor of Pharmacy</option>
                    <option >Doctor of Pharmacy (Post Baccalaureate)</option>
                    <option >Executive MBA (EMBA)</option>
                    <option >M.Pharm + MBA (Integrated)</option>
                    <option >M.Phil. + Ph.D (Integrated)</option>
                    <option >M.Tech + PhD (Integrated)</option>
                    <option >Master Degree in Hospital Management (MDHM)</option>
                    <option >Master of Architecture (M.Arch)</option>
                    <option >Master of Arts (M.A.)</option>
                    <option >Master of Business Administration (MBA - International)</option>
                    <option >Master of Business Administration (MBA)</option>
                    <option >Master of Commerce (M.Com)</option>
                    <option >Master of Computer Application (MCA)</option>
                    <option >Master of Design (M.Des)</option>
                    <option >Master of Education (M.Ed)</option>
                    <option >Master of Hospital Administration</option>
                    <option >Master of Human Resource Management</option>
                    <option >Master of Interior Design</option>
                    <option >Master of Law (LLM)</option>
                    <option >Master of Library and Information Science (MLIS)</option>
                    <option >Master of Optometry (M.Optom.)</option>
                    <option >Master of Pharmacy (M.Pharm)</option>
                    <option >Master of Philosophy (M.Phil)</option>
                    <option >Master of Physical Education (MPEd)</option>
                    <option >Master of Public Health (MPH)</option>
                    <option >Master of Science (M.Sc)</option>
                    <option >Master of Social Work (MSW)</option>
                    <option >Master of Technology (M.Tech)</option>
                    <option >Master of Travel &amp; Tourism Management</option>
                    <option >Masters (MS)-Research</option>
                    <option >Masters in Mass Communication (MMC)</option>
                    <option >Masters of Physiotherapy (MP)</option>
                    <option >Ph.D</option>
                    <option >Post Graduate Diploma in Management(PGDM)</option>
                    <option >Post Graduate Diploma(PGD)</option>
                </select>
            </div>
        </div>

        <div class="col-md-2 col-sm-4 col-xs-12" v-if="!course_info_present">
            <div class="form-group institutesDropdown_slider">
                <label for="sel1" class="white_text">Discipline</label>
                <select class="form-control" id="drpDiscipline" name="course_type" required="">
                    <option >Architecture</option>
                    <option >Arts</option>
                    <option >Commerce</option>
                    <option >Dental</option>
                    <option >Design</option>
                    <option >Engineering</option>
                    <option >Humanities</option>
                    <option >Law</option>
                    <option >Management</option>
                    <option >Medical</option>
                    <option >Optometry</option>
                    <option >Pharmacy</option>
                    <option >Science</option>
                </select>
            </div>
        </div>
        
        <div class="col-md-2 col-sm-4 col-xs-12" v-if="!course_info_present">
            <div class="form-group institutesDropdown_slider">
                <label for="sel1" class="white_text">Program Level</label>
                <select class="form-control" id="drpProgramLevel" name="course_level" required="">
                    <option >Diploma</option>
                    <option >Dual Bachelors And Masters Degree</option>
                    <option >Dual Bachelors Degree</option>
                    <option >Dual Masters</option>
                    <option >Integrated PhD</option>
                    <option >PhD</option>
                    <option >Post Graduate (PG)</option>
                    <option >Post Graduate Diplomas</option>
                    <option >Under Graduate (UG)</option>
                </select>
            </div>
        </div>
    </form>
</template>
<script>
export default {
    data(){
        return{
            course_info_present:'',
        };
    }
}
</script>