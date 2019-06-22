<?php

use App\Eula;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

    class CreateEulaBasedOnCv2x extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* @var $eula_id integer */
        $eula_id = DB::table('eula')->insertGetId([
            'effective_date' => Carbon::now(),
        ]);

        $eula_text = '<strong>Licence</strong>

                <p>By accessing or using the Platform, you agree to the terms of this Agreement. If you do not accept the terms of this Agreement, you will not be able to access or use the Platform. You acknowledge that Actionable receives valuable consideration from your use of the Platform (including Data you submit to the same) and also from Actionable’s Consulting Partner and/or your Organisation.
                
                <p>Actionable grants you a limited, non-exclusive, non-transferable, non-assignable, non-sub licensable, revocable license to use (but not commercialise) the Platform and applicable Modules solely for the purposes which they are provided (primarily being to assist with frequent, relevant, collaborative and measurable change within the Organisation). To avoid doubt, your licence to use the Modules is limited to the Modules which your Organisation has contracted for with Actionable’s Consulting Partner from time to time. Except as required by the mandatory operation of Law all implied terms and conditions are excluded from this Agreement.
                
                <p>You have no right to hire, licence or allow any other person to use the Platform. You agree that Actionable may from time to time upgrade or change the functionality and/or look and feel of the Platform.
                
                <p><strong>Data and Privacy</strong>
                
                <p>The Platform allows you to create, publish, send, receive, forward or otherwise transmit Data. You remain solely responsible for what Data you create or send via the Platform including who you transmit the Data to.
                
                <p>You warrant that you have the right to use all Data that you transmit via the Platform and in doing so you do not breach any obligations of confidentiality, contractual arrangements or Laws. You are solely responsible for the accuracy, integrity and reliability of your Data. You warrant that no Data or other information that you transmit will infringe the Intellectual Property rights of any third party.
                
                <p>In respect of Data you create and send via the Platform you acknowledge and agree that we have a perpetual irrevocable licence at no cost:
                <ul>
                    <li>to use the Data to:
                <ul>
                    <li><strong>improve Platform user experience;</strong></li>
                    <li><strong>improve Platform and Module content;</strong></li>
                    <li><strong>better understand patterns of use, both within and across organisations;</strong></li>
                    <li><strong>better understand where opportunities for further learning may exist, both within and across organisations; and</strong></li>
                    <li><strong>better understand drivers of engagement;</strong></li>
                </ul>
                </li>
                    <li>to provide the Data to Actionable’s Consulting Partner for use by the Consulting Partner in providing services to you and your Organisation;</li>
                    <li>to aggregate your Data with other users’ data from the Platform (being other users of the Platform in your Organisation and/or users at third party organisations) (<strong>Aggregated Data</strong>) and use the same in respect of the matters set out in clause 6.1; and
                use and develop Aggregated Data to determine which Modules are most effective and create data, materials and reports as to the Platform, Modules and change improvement results and benchmarking including in respect of particular industries and to commercialise, sell or licence the same.</li>
                </ul>
                <p>You agree that we may sell, licence or disclose the Aggregated Data which includes or is derived in part from your Data and you have no claim in respect of the same and acknowledge that Actionable is the sole owner of the Aggregated Data. To avoid doubt, nothing in this Agreement gives us any rights to any Organisational Data you transmit or disclose via the Platform.
                
                <p>Actionable will comply with all applicable Privacy Laws, in relation to any of your Personal Information Actionable collects, uses or discloses in connection with this Agreement including from your use of the Platform. Subject to this Agreement, Actionable will only use or disclose your Personal Information with your consent or as allowed under applicable Privacy Laws. You acknowledge, agree and consent to the disclosure of your Personal Information to your Organisation arising from your use of the Platform. You agree to comply with applicable Privacy Laws, in relation to collection, use or disclosure of any other person’s Personal Information when using the Platform.
                
                <p>You agree that Actionable may contact you by email or other means to update you about the Platform.
                
                <p><strong>Your General Obligations</strong>
                
                <p>In using the Platform you will communicate and generally deal with others in your Organisation and Actionable’s Consulting Partner. At all times you agree you are solely responsible for your interactions and conduct with other users when using the Platform.
                
                <p>You will ensure that the content of your Data and other information sent via the Platform does not contain obscene, defamatory, libellous or threatening materials or which encourages criminal or illegal conduct.
                
                <p>We have no obligation to either monitor the content provided by you or your use of the Platform. However, we may monitor and remove any such content if we believe, or it is alleged, to breach the terms of this Agreement, Laws or any third party’s or other user’s Intellectual Property rights.
                
                <p><strong>Intellectual Property</strong>
                
                <p>We warrant that we own or have the rights to use all of the Intellectual Property in the Platform and/or Modules and have the rights to enter into this Agreement with you.
                
                <p>Nothing in this Agreement transfers any ownership in either the Platform, Modules or the Intellectual Property in the same to you. You acknowledge that the Intellectual Property in the Modules may be owned by third parties, that Actionable has a licence to use the same and that you will not reproduce or distribute the Modules to any third party.
                
                <p>You acknowledge that the name “Actionable” and the Actionable logo are Actionable’s trade or service marks or otherwise owned by Actionable’s related companies (<strong>Marks</strong>). You are not authorised to use any of the Marks in any advertising, publicity or any other commercial manner without Actionable’s prior consent and your use of the Platform does not give you any title or ownership in the Marks. You agree that we own for free, all Intellectual Property in any feedback or suggestions you provide to us in respect of the Platform and any Modules.
                
                <p>You will not (directly or indirectly) reverse engineer, decompile, disassemble, or otherwise attempt to discover the source code or underlying structure, ideas, or algorithms of, or found at or through the Platform.
                
                <p>You agree to comply with the following in respect of any claim or allegation that the Platform or Modules infringe the Intellectual Property rights of a third party. You must inform us as soon as reasonably practicable following you becoming aware of any allegation or claim that the Platform or Modules infringe the Intellectual Property rights of any third party and provide all relevant materials to Actionable. If any claim or action in respect to the Platform or Module infringes the Intellectual Property rights of a third party Actionable may:
                <ul>
                    <li>procure for you a right to continue using the Platform or Modules from the party bringing or succeeding in the claim or action;</li>
                    <li>amend the Platform or Module so they no longer infringe the Intellectual Property rights of a third party; and/or</li>
                    <li>terminate this Agreement without liability.</li>
                </ul>
                <p>In respect of any <strong><em>moral rights</em></strong> (as defined in the <em>Copyright Act</em> or other applicable legislation) which accrue to you in creating Data you agree to waive those rights so Actionable (a) need not attribute to you any authorship of such work, and (b) can change or adapt such work in any way without your consent.
                
                <p><strong>Term and Termination</strong>
                
                <p>Your rights to access the Platform commence once you accept these terms and your Organisation has entered into a contract with Actionable’s Consulting Partner. The Modules you may access from the Platform will be determined by what Modules your Organisation licences from time to time from Actionable’s Consulting Partner. Where your Organisation ceases to have a right to allow you to access the Platform and Modules, your rights under this Agreement will also cease.
                
                <p>We may terminate this Agreement or your rights to use the Platform or a Module where in Actionable’s sole discretion we consider you are breaching this Agreement, you have ceased to work for the Organisation or the Organisation directions to do so, or we consider you are infringing a third party’s Intellectual Property in your use of the Platform.
                
                <p>To the extent permitted by Law, we make no warranty or representation as to fitness for use or performance or compatibility or otherwise of the Platform or Modules or the results which may be obtained via use of the same. As the Platform is provided over the internet, Actionable cannot and do not make any warranty or representation that:
                <ul>
                    <li>the Platform will be available without interruption or will be timely or error free; or</li>
                    <li>Data stored will be accurate or reliable, however we will use reasonable efforts (including meeting industry standards) to ensure that the accuracy and reliability of Data submitted by you for storage is not altered in the system.</li>
                </ul>
                <strong>Liability</strong>
                
                <p>We will not be liable to you for any loss, damage, costs or expenses arising from corruption to your Data or failure to store, make available or update such Data. You acknowledge that we give no warranty as to the accuracy, integrity or completeness of any Data.
                
                <p>Under no circumstances will Actionable be liable to you or any other person for any consequential, contingent, special or indirect losses, including loss of business, revenue or profit with respect to claims arising in connection to this Agreement including from any act or omission by Actionable, Actionable breaching this Agreement, your use of the Platform or Modules, a breach of Laws, negligence or under any other theory of law including where Actionable or you were aware or had been told of the possibility of any such damage or loss.
                
                <p>Actionable’s maximum liability to you from any acts or omissions, breach of this Agreement or Laws, or for negligence or under any other theory of law is limited to USD$10. You agree that this clause is:
                <ul>
                    <li>a genuine pre-estimate of the likely loss and damage you may suffer in respect of the matters set out in that clause; and</li>
                    <li>an essential basis of the bargain in making this Agreement and that without the availability of enforcing this provision as written, Actionable would not grant you access to the same.</li>
                </ul>
                <p>Your use of the Platform (and the software that powers the same) is subject to any export or re-export technology control Laws that apply to you (Export Control Laws). You shall strictly comply with all such Export Control Laws and warrant you are not prohibited from receiving US origin software, goods or services.
                
                <p><strong>General</strong>
                
                <p>You may not assign your rights under this Agreement without Actionable’s prior written consent. We may use third parties to provide any part of the Platform or Modules.
                
                <p>Actionable can only waive any of Actionable’s rights under this Agreement by written notice to you.
                
                <p>This Agreement is governed by the Laws of the jurisdiction where Actionable’s registered office is located (<strong>Applicable Jurisdiction</strong>) and Actionable and you submit to the non-exclusive jurisdiction of the courts of that jurisdiction.
                
                <p>Clauses 5, 6, 7, 8, 14, 15, 16, 18, 23 and 24 survive the termination of this Agreement.
                
                <p>To the extent allowed by Laws you agree that all international conventions and treaties which would apply to this Agreement and which are excludable by the contracting parties are excluded from applying to this Agreement.
                
                <p><strong>Interpretation</strong>
                
                <p>In this Agreement:
                <ul>
                    <li>singular includes plural and vice versa;</li>
                    <li>reference to a person includes a body politic or corporate, an individual and a partnership and vice versa;</li>
                    <li>a reference to you includes your employees and agents and any acts and omissions of the same will be deemed to be your acts and omissions;</li>
                    <li>a reference to a clause means all subclauses of a clause unless otherwise stated;</li>
                    <li>consent may only be given in writing;</li>
                    <li>no rule of construction applies to Actionable’s disadvantage because we put forward this Agreement; and</li>
                    <li>if a provision of this Agreement would, but for this clause, be unenforceable (a) the provision must be read down to the extent necessary to avoid that result and (b) if the provision cannot be read down to that extent, it must be severed without affecting the validity and enforceability of the remainder of this Agreement.</li>
                </ul>
                <strong>Meanings</strong>
                
                <p>In this Agreement:
                
                <p><strong>Actionable</strong> means [insert applicable Actionable entity.]
                <p><strong>Agreement</strong> means this end user licence agreement under which Actionable grants you the rights to access and use the Platform and certain Modules from time to time.
                <p><strong>Consulting Partner</strong> means Actionable’s consulting partner who procures a licence from Actionable that allows your organisation to use the Platform and Modules.
                <p><strong>Data</strong> means data and information that you publish, send, forward, otherwise transmit or receive by means of the Platform or generate via the Platform.
                <p><strong>Intellectual Property</strong> means all Intellectual Property rights, title and interest in anything including (a) copyright (including in computer software and source code, development and performance documentation, manuals, engineering documentation and price lists), and (b) all patent and design rights (registered or unregistered) and any applications for the same, and (c) the trade marks and service mark rights.
                <p><strong>Laws</strong> means all applicable laws (general law, statute and equity) and mandatory standards which are in force in the Applicable Jurisdiction and in respect of your use of the Platform and Modules the place where you use the same.
                <p><strong>Module</strong> means any module which is made available to you and which you access and use via the Platform.
                <p><strong>Organisation</strong> means the organisation for whom you work.
                <p><strong>Organisational Data</strong> means proprietary data of you Organisation which you send, share or transmit via the Platform.
                <p><strong>Personal Information</strong> means information or an opinion, whether true or not, and whether recorded in a material form or not, about an individual whose identity is apparent, or can reasonably be ascertained, from the information or opinion.
                <p><strong>Platform</strong> means any digital platform, methodology and or intellectual property owned and operated by Actionable from time to time, including but not limited to Actionable Books, Actionable Consultant, Actionable Conversations, Actionable Training, Actionable Learning, Actionable Insights, Actionable Audio and Make It Actionable and where applicable include Modules provided under the same.
                <p><strong>Privacy Laws</strong> means any legislation and codes binding on the applicable party relating to the protection of privacy or handling of Personal Information.
        ';
        

        DB::table('eula_text')->insert([
            'eula_id' => $eula_id,
            'locale_code' => 'en_US',
            'eula_text' => $eula_text,
        ]);

        DB::table('eula_text')->insert([
            'eula_id' => $eula_id,
            'locale_code' => 'en_CA',
            'eula_text' => $eula_text,
        ]);

        DB::table('eula_text')->insert([
            'eula_id' => $eula_id,
            'locale_code' => 'en_FR',
            'eula_text' => $eula_text,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
