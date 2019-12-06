<template>
    <form>
           <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group institutesDropdown_slider">
                        <label for="sel1" class="white_text">Discipline</label>
                        <select class="form-control" id="drpDiscipline" name="Discipline_ID" required=""><option value="">All</option>
                            <option value="8">Architecture</option>
                            <option value="9">Arts</option>
                            <option value="10">Commerce</option>
                            <option value="60">Dental</option>
                            <option value="61">Design</option>
                            <option value="11">Engineering</option>
                            <option value="12">Humanities</option>
                            <option value="13">Law</option>
                            <option value="14">Management</option>
                            <option value="15">Medical</option>
                            <option value="62">Optometry</option>
                            <option value="16">Pharmacy</option>
                            <option value="17">Science</option>
                            </select>
                    </div>
                </div>
                 <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group institutesDropdown_slider">
                        <label for="sel1" class="white_text">Program Level</label>
                        <select class="form-control" id="drpProgramLevel" name="ProgrammeLevel_ID" required=""><option value="">All</option>
                            <option value="13">Diploma</option>
                            <option value="18">Dual Bachelors And Masters Degree</option>
                            <option value="15">Dual Bachelors Degree</option>
                            <option value="19">Dual Masters</option>
                            <option value="21">Integrated PhD</option>
                            <option value="20">PhD</option>
                            <option value="16">Post Graduate (PG)</option>
                            <option value="17">Post Graduate Diplomas</option>
                            <option value="14">Under Graduate (UG)</option>
                            </select>
                    </div>
                </div>
                 <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="form-group institutesDropdown_slider">
                        <label for="sel1" class="white_text">Nature of Courses</label>
                        <select class="form-control" id="drpNatureofcourse" name="Natureofcourse" required=""><option value="">All</option>
                    <option value="120">B. Pharma + MBA (Integrated)</option>
                    <option value="157">B.A + L.L B</option>
                    <option value="158">B.B.A. + L.L.B.</option>
                    <option value="89">B.Com + LLB (Hons. Integrated)</option>
                    <option value="91">B.Tech + M.Tech (Integrated)</option>
                    <option value="92">B.Tech + MBA (Integrated)</option>
                    <option value="94">BA + LLB (Hons. Integrated)</option>
                    <option value="95">BA + LLB (Integrated)</option>
                    <option value="160">Bachelor in Clinical Optometry (B.Optom.)</option>
                    <option value="8">Bachelor in Multimedia Communication(BMMC)</option>
                    <option value="9">Bachelor of Architecture (B.Arch)</option>
                    <option value="13">Bachelor of Arts (BA - 3 Continent)</option>
                    <option value="11">Bachelor of Arts (BA)</option>
                    <option value="14">Bachelor of Arts (Honors)</option>
                    <option value="15">Bachelor of Business Administration (BBA)</option>
                    <option value="126">Bachelor of Business Administration (BBA) (Honors)</option>
                    <option value="16">Bachelor of Commerce (B.Com)</option>
                    <option value="17">Bachelor of Commerce (Honors)</option>
                    <option value="20">Bachelor of Computer Application (BCA - Evening)</option>
                    <option value="21">Bachelor of Computer Application (BCA)</option>
                    <option value="22">Bachelor of Design (B.Des)</option>
                    <option value="24">Bachelor of Education (B.Ed)</option>
                    <option value="26">Bachelor of Engineering (B.E.)</option>
                    <option value="27">Bachelor of Environment Management (BEM)</option>
                    <option value="28">Bachelor of Fashion Technology (BFT)</option>
                    <option value="29">Bachelor of Fine Arts (BFA)</option>
                    <option value="30">Bachelor of Hotel Management</option>
                    <option value="31">Bachelor of Hotel Management &amp; Catering Technology (BHM &amp; CT)</option>
                    <option value="32">Bachelor of Interior Design</option>
                    <option value="33">Bachelor of Law (LLB)</option>
                    <option value="127">Bachelor of Library and Information Science (BLIS)</option>
                    <option value="34">Bachelor of Management Studies (BMS)</option>
                    <option value="35">Bachelor of Occupational Therapy</option>
                    <option value="36">Bachelor of Pharmacy (B.Pharm)</option>
                    <option value="37">Bachelor of Physical Education &amp; Sports</option>
                    <option value="38">Bachelor of Physiotherapy</option>
                    <option value="39">Bachelor of Planning</option>
                    <option value="124">Bachelor of Public Health</option>
                    <option value="40">Bachelor of Science (B.Sc)</option>
                    <option value="41">Bachelor of Science (Honors)</option>
                    <option value="43">Bachelor of Social Work (BSW)</option>
                    <option value="44">Bachelor of Statistics</option>
                    <option value="45">Bachelor of Technology (B.Tech)</option>
                    <option value="49">Bachelor of Vocation (B.Voc.)</option>
                    <option value="97">BBA + LLB  (Integrated)</option>
                    <option value="98">BBA + LLB (Hons. Integrated)</option>
                    <option value="99">BBA + MBA (Integrated)</option>
                    <option value="100">BCA + MCA (Intergrated)</option>
                    <option value="101">BSC + MSC (Intergrated)</option>
                    <option value="152">Diploma</option>
                    <option value="159">Doctor of Pharmacy</option>
                    <option value="154">Doctor of Pharmacy (Post Baccalaureate)</option>
                    <option value="50">Executive MBA (EMBA)</option>
                    <option value="102">M.Pharm + MBA (Integrated)</option>
                    <option value="103">M.Phil. + Ph.D (Integrated)</option>
                    <option value="156">M.Tech + PhD (Integrated)</option>
                    <option value="51">Master Degree in Hospital Management (MDHM)</option>
                    <option value="52">Master of Architecture (M.Arch)</option>
                    <option value="53">Master of Arts (M.A.)</option>
                    <option value="55">Master of Business Administration (MBA - International)</option>
                    <option value="56">Master of Business Administration (MBA)</option>
                    <option value="57">Master of Commerce (M.Com)</option>
                    <option value="58">Master of Computer Application (MCA)</option>
                    <option value="60">Master of Design (M.Des)</option>
                    <option value="61">Master of Education (M.Ed)</option>
                    <option value="63">Master of Hospital Administration</option>
                    <option value="64">Master of Human Resource Management</option>
                    <option value="65">Master of Interior Design</option>
                    <option value="67">Master of Law (LLM)</option>
                    <option value="68">Master of Library and Information Science (MLIS)</option>
                    <option value="161">Master of Optometry (M.Optom.)</option>
                    <option value="70">Master of Pharmacy (M.Pharm)</option>
                    <option value="71">Master of Philosophy (M.Phil)</option>
                    <option value="72">Master of Physical Education (MPEd)</option>
                    <option value="74">Master of Public Health (MPH)</option>
                    <option value="75">Master of Science (M.Sc)</option>
                    <option value="76">Master of Social Work (MSW)</option>
                    <option value="79">Master of Technology (M.Tech)</option>
                    <option value="80">Master of Travel &amp; Tourism Management</option>
                    <option value="81">Masters (MS)-Research</option>
                    <option value="82">Masters in Mass Communication (MMC)</option>
                    <option value="84">Masters of Physiotherapy (MP)</option>
                    <option value="87">Ph.D</option>
                    <option value="107">Post Graduate Diploma in Management(PGDM)</option>
                    <option value="108">Post Graduate Diploma(PGD)</option>
                    </select>
                </div>
            </div>
                 <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="form-group institutesDropdown_slider">
                        <label for="sel1" class="white_text">Institute Type:</label>
                        <select class="form-control" id="drpInstituteType" name="InstituteType" required=""><option value="">All</option>
<option value="Private">Private</option>
<option value="Public">Public</option>
</select>
                    </div>
                </div>
    </form>
</template>