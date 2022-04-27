<template>
  <div class="row">
    <div class="col-md-12 mt-1">
      <article>
        <p>
          The humanities entail the study of the human world and society from a critical perspective. This field includes popular majors like English, history, and philosophy. In these disciplines, students investigate humanity itself (hence the name), applying critical methods to help them understand literature, art, and the past, as well as human morality, culture, and values.
        </p>
        <p>
          Each humanities discipline relies on unique interpretation methods. Historians use the historical method, which can be further divided into branches like cultural history, quantitative history, and oral history.

          Meanwhile, English and foreign languages use textual criticism to interpret sources, and philosophy applies conceptual analysis and experimental approaches.
        </p>
      </article>
    </div>

    <div 
      v-if="AuthUser.is_pro_member"
      class="row"
    >
      <div class="col-md-12 mt-1">
        <h4>Quality Required</h4>
      </div>
      <hr class="mb-0 mt-0">
      <div class="col-md-12 p-2">
        <ul>
          <li class>
            Academic, People and Creative Orientation
          </li>
          <li class>
            Good with Logical Thinking and Arguments Interest in Politics and Social Issues
          </li>
          <li class>
            Ability to spend long hours in reading and writing both during study and later in the profession.
          </li>
        </ul>
      </div>
      <div class="col-md-12 mt-1">
        <h4>Entrance Exams</h4>
      </div>
      <hr class="mb-0 mt-0">
      <div class="col-md-12 p-2">
        <div class="d-flex pt-2 w-50 justify-content-between">
          <ul>
            <h5>You Can be:</h5>
            <li class>
              CLAT (21 NLU’s)
            </li>
            <li class>
              AILET (NLU-Delhi)
            </li>
            <li class>
              SLAT (Symbiosis)
            </li>
            <li class>
              CUET (Christ)
            </li>
            <li class>
              BLAT (BHU)
            </li>
            <li class>
              CET-BVP
            </li>
            <li class>
              JMI-ET (Jamia)
            </li>
            <li class>
              AMU-ET (Aligarh)
            </li>
          </ul>
          <ul>
            <h5>You Can be:</h5>
            <li class>
              MH-CET
            </li>
            <li class>
              ULSAT (UPES)
            </li>
            <li class>
              KIIT-ET (Kalinga)
            </li>
            <li class>
              MSU-ET
            </li>
            <li class>
              AIL-LET (Army Inst.)
            </li>
            <li class>
              KLEE (Kerala)
            </li>
            <li class>
              RULET (Rajasthan)
            </li>
            <li class>
              PU-LLB-ET
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-12 mt-1">
        <h4>Career Options</h4>
      </div>
      <hr class="mb-0 mt-0">
      <div class="col-md-12 p-2">
        <div class="d-flex pt-2 w-50 justify-content-between">
          <ul>
            <h5>You Can be:</h5>
            <li class>
              Advocate
            </li>
            <li class>
              Arbitrator
            </li>
            <li class>
              Conciliator
            </li>
            <li class>
              Corporate Legal Consultant
            </li>
            <li class>
              Diplomat
            </li>
            <li class>
              Investigator
            </li>
            <li class>
              Judge
            </li>
            <li class>
              Judicial Magistrate
            </li>
          </ul>
          <ul>
            <h5>You Can be:</h5>
            <li class>
              Lawyer
            </li>
            <li class>
              Legal Advisor
            </li>
            <li class>
              Litigator
            </li>
            <li class>
              Mediator
            </li>
            <li class>
              Professor
            </li>
            <li class>
              Prosecutor
            </li>
            <li class>
              Social Activist
            </li>
            <li class>
              Solicitor
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
	components :{
	}
};
</script>