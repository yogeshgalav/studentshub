<template>
  <div class="row">
    <div class="col-md-12 mt-1">
      <article>
        <p>
          Human rights are rights inherent to all human beings, regardless of gender, nationality, place of residency, sex, ethnicity, religion, color or and other categorization. Thus, human rights are non-discriminatory, meaning that all human beings are entitled to them and cannot be excluded from them. Of course, while all human beings are entitled to human rights, not all human beings experience them equally throughout the world. Many governments and individuals ignore human rights and grossly exploit other human beings.

          There are a variety of human rights, including:
          Civil rights (such as the rights to life, liberty and security),
          Political rights (like rights to the protection of the law and equality before the law),
          Economic rights (including rights to work, to own property and to receive equal pay),
          Social rights (like rights to education and consenting marriages),
          Cultural rights (including the right to freely participate in their cultural community), and
          Collective rights (like the right Career in Law and Humanity
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