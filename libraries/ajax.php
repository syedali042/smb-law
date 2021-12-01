<?php
/**
 * Filename: ajax.php
 * Date: 11/28/12
 */

class LB_AJAX
{
	public $assets = <<<ASSET
<tr>
    <td colspan="3"><p class="sec">The name, place of birth, birth date and sex of each child; the present address, periods of residence, and places where each child has lived within the past five (5) years; and the name, present address and relationship to the child of each person with whom the child has lived during that time are:</p></td>
</tr>
<tr>
    <td colspan="3"><h3><b>1.</b>THE FOLLOWING INFORMATION IS TRUE ABOUT CHILD</h3></td>
</tr>
<tr>
    <td><label for="id_fb">Child's Full Legal Name</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_fb" name="field_fb"/></td>
</tr>
<tr>
    <td><label for="id_fb">Place of Birth</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_fc" name="field_fc"/></td>
</tr>
<tr>
    <td><label for="id_fc">Date of Birth</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_fd" name="field_fd"/></td>
</tr>
<tr>
    <td><label for="id_fd">Soc. Sec. No.</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_fe" name="field_fe"/></td>
</tr>
<tr>
    <td><label for="id_fe">Sex</label></td>
    <td>&nbsp;</td>
    <td><input type="radio" id="id_fe" name="field_fe" value="Male" class="radio"/>Male
        <input type="radio" id="id_fe" name="field_fe" value="Female" class="radio"/>Female
    </td>
</tr>
<tr>
    <td><label for="id_ff">The number of addresses child 1 has resided at for the past 5 years?</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_fg" name="field_fg"/></td>
</tr>
<tr>
    <td><label for="id_fg">Address No. 1</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_fh" name="field_fh"/></td>
</tr>
<tr>
    <td><label for="id_fh">City</label></td>
    <td>&nbsp;</td>
    <td><select name="field_fh" id="id_fh">
        <option value="">Choose</option>
        <option value="1">Yes</option>
    </select>
    </td>
</tr>
<tr>
    <td><label for="id_fi">State</label></td>
    <td>&nbsp;</td>
    <td><select name="field_fi" id="id_fi">
        <option value="">Choose</option>
        <option value="1">Yes</option>
    </select>
    </td>
</tr>
<tr>
    <td><label for="id_fk">Date ( From )</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_fl" name="field_fl"/></td>
</tr>
<tr>
    <td><label for="id_fl">Date ( To )</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_fm" name="field_fm"/></td>
</tr>
<tr>
    <td colspan="3"></td>
</tr>
<tr>
    <td><label for="id_fm">Name of person child lived with Presently</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_fn" name="field_fn"/></td>
</tr>
<tr>
    <td><label for="id_fn">Present Address (of person child living with)</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_fo" name="field_fo"/></td>
</tr>
<tr>
    <td><label for="id_fo">City</label></td>
    <td>&nbsp;</td>
    <td><select name="field_fo" id="id_fo">
        <option value="">Choose</option>
        <option value="1">Yes</option>
    </select>
    </td>
</tr>
<tr>
    <td><label for="id_fp">State</label></td>
    <td>&nbsp;</td>
    <td><select name="field_fp" id="id_fp">
        <option value="">Choose</option>
        <option value="1">Yes</option>
    </select>
    </td>
</tr>
<tr>
    <td><label for="id_fq">Relationship to child</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_fr" name="field_fr"/></td>
</tr>
<tr>
    <td colspan="3"><h3><b>2.</b>PARTICIPATION IN CUSTODY OR TIME_SHARING PROCEEDINGS</h3></td>
</tr>
<tr>
    <td><label for="id_fs">I HAVE/HAVE NOT participated as a party, witness or in any capacity in any other litigation or custody proceeding in this or any other state, concerning custody or time-sharing with a child subject to his proceeding</label></td>
    <td>&nbsp;</td>
    <td><input type="radio" id="id_fs" name="field_fs" value="Have" class="radio"/>Have
        <input type="radio" id="id_fs" name="field_fs" value="Have Not" class="radio"/>Have Not
    </td>
</tr>
<tr>
    <td><label for="id_ft">If you HAVE, Please Explain</label></td>
    <td>&nbsp;</td>
    <td><textarea id="id_ft" name="field_ft" class="textarea"></textarea></td>
</tr>
<tr>
    <td colspan="3"><h3><b>3.</b>INFORMATION ABOUT CUSTODY OR TIME-SHARING PROCEEDINGS</h3></td>
</tr>
<tr>
    <td><label for="id_fv">I HAVE/HAVE NOT information about any custody or time-sharing proceedings pending in a court of this or any oher state concerning a child subject to this proceedings</label></td>
    <td>&nbsp;</td>
    <td><input type="radio" id="id_fv" name="field_fv" value="Have" class="radio"/>
        Have
        <input type="radio" id="id_fv" name="field_fv" value="Have Not" class="radio"/>
        Have Not
    </td>
</tr>
<tr>
    <td><label for="id_fw">If you HAVE, Please Explain</label></td>
    <td>&nbsp;</td>
    <td><textarea id="id_fw" name="field_fw" class="textarea"></textarea></td>
</tr>
<tr>
    <td colspan="3"><h3><b>4.</b>PERSON NOT A PARTY TO THIS PROCEEDING</h3></td>
</tr>
<tr>
    <td><label for="id_fy">I KNOW/DO NOT KNOW ANY PERSON not a party to this proceeding who has physical custody or claims to have custody, visitation or time-sharing with any respect to any child subject to this proceeding</label></td>
    <td>&nbsp;</td>
    <td><input type="radio" id="id_fy" name="field_fy" value="Know" class="radio"/>Know

        <input type="radio" id="id_fy" name="field_fy" value="Do Not Know" class="radio"/>Do Not Know
    </td>
</tr>
<tr>
    <td><label for="id_fz">If you KNOW, please Explain</label></td>
    <td>&nbsp;</td>
    <td><textarea id="id_fz" name="field_fz" class="textarea"></textarea></td>
</tr>
<tr>
    <td colspan="3"><h3><b>5.</b>KNOWLEDGE OF PRIOR CHILD SUPPORT PROCEEDING</h3></td>
</tr>
<tr>
    <td><label for="id_gb">The children described in this affidavit ARE/ARE NOT subject to existing child support orders in this or any state or territory</label></td>
    <td>&nbsp;</td>
    <td><input type="radio" id="id_gb" name="field_gb" value="Are" class="radio"/>Are
        <input type="radio" id="id_gb" name="field_gb" value="Are Not" class="radio"/>Are Not
    </td>
</tr>
<tr>
    <td><label for="id_gc">If they ARE, Please Explain</label></td>
    <td>&nbsp;</td>
    <td><textarea id="id_gc" name="field_gc" class="textarea"></textarea></td>
</tr>
<tr>
    <td colspan="3"><h3><b>6.</b>HEALTH INSURANCE</h3></td>
</tr>
<tr>
    <td><label for="id_ge">Is health insurance reasonably available at this time</label></td>
    <td>&nbsp;</td>
    <td><input type="radio" id="id_ge" name="field_ge" value="1" class="radio"/>Yes
        <input type="radio" id="id_ge" name="field_ge" value="0" class="radio"/>No
    </td>
</tr>
<tr>
    <td><label for="id_ge">Which parent will maintain Health Insurance coverage for the minor child(ren)</label></td>
    <td>&nbsp;</td>
    <td><input type="radio" id="id_ge" name="field_ge" value="Mother" class="radio"/>Mother
        <input type="radio" id="id_ge" name="field_ge" value="Father" class="radio"/>Father
    </td>
</tr>
<tr>
    <td><label for="id_gf">If NO, have you and your spouse AGREED that any uninsured medical cost fot the minor child(ren) shall be</label></td>
    <td>&nbsp;</td>
    <td><input type="radio" id="id_gf" name="field_gf" value="Shared Equally" class="radio"/>Shared Equally
        <input type="radio" id="id_gf" name="field_gf" value="Prorated according to the child support guideline percentages" class="radio"/>Prorated according to the child support guideline percentages</td>
</tr>
<tr><td colspan="3"><h3><b>7.</b>DENTAL INSURANCE</h3></td></tr>
<tr>
    <td><label for="id_gh">Is Dental insurance reasonably available at this time</label></td>
    <td>&nbsp;</td>
    <td><input type="radio" id="id_gh" name="field_gh" value="1" class="radio"/>Yes
        <input type="radio" id="id_gh" name="field_gh" value="0" class="radio"/>No
    </td>
</tr>
<tr>
    <td><label for="id_ge">Which parent will maintain Dental Insurance coverage for the minor child(ren)</label></td>
    <td>&nbsp;</td>
    <td><input type="radio" id="id_ge" name="field_ge" value="Mother" class="radio"/>Mother
        <input type="radio" id="id_ge" name="field_ge" value="Father" class="radio"/>Father
    </td>
</tr>
<tr>
    <td><label for="id_gi">Which parent will maintain Dental insurance coverage of the minor child(ren)</label></td>
    <td>&nbsp;</td>
    <td><input type="radio" id="id_gi" name="field_gi" value="Shared Equally" class="radio"/>Shared Equally
        <input type="radio" id="id_gi" name="field_gi" value="Prorated according to the child support guideline percentages" class="radio"/>Prorated according to the child support guideline percentages</td>
</tr>
<tr>
    <td colspan="3"><h3><b>8.</b>Life Insurance</h3></td>
</tr>
<tr>
    <td><label for="id_gk">Is either parent required to mainain life insurane coverage for the benefit of the parties, minor child(ren)</label></td>
    <td>&nbsp;</td>
    <td><input type="radio" id="id_gk" name="field_gk" value="1" class="radio"/>Yes
        <input type="radio" id="id_gk" name="field_gk" value="0" class="radio">No
    </td>
</tr>
<tr>
    <td><label for="id_gl">How much will be paid</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_gm" name="field_gm" value="$"></td>
</tr>
<tr>
    <td><label for="id_gm">if YES, will Mother or Father provide insurance and state the amount of the requiredc coverage to be provided until the youngest child turns 18, becomes amancipated, marries, die or otherwise become self-supporting</label></td>
    <td>&nbsp;</td>
    <td><input type="radio" id="id_gm" name="field_gm" value="Mother" class="radio"/>Mother
        <input type="radio" id="id_gm" name="field_gm" value="Father" class="radio"/>Father</td>
</tr>
<tr><td colspan="3"><h3><b>9.</b>TAX DEDUCTION</h3></td></tr>
<tr>
    <td><label for="id_go">What agreement have you and your spouse made regarding the income tax deduction for the child(ren):</label></td>
    <td>&nbsp;</td>
    <td><textarea id="id_go" name="field_go" class="textarea"></textarea></td>
</tr>
<tr>
    <td colspan="3"><h3><b>10.</b>PARENTING CLASS</h3></td>
</tr>
<tr>
    <td colspan="3"><p class="info">You and your spouse MUST take a parenting class and file the certificate of completion with the Court before your final hearing. TO find a class in your area  <a href="http://localhost/twitter/#">CLICK HERE</a> and scroll down to your County. Click here to sign up for the ONLINE CLASS.</p></td>
</tr>
<tr><td colspan="3"><h3><b>11.</b>CHILD SUPPORT - WATCH VIDEO - VERY IMPORTANT</h3></td></tr>
<tr>
    <td colspan="3"><p class="info">ACCORDING TO FLORIDA LAW CHILD SUPPORT MUST BE CALCULATED IN EVERY CASE IF THER ARE MINOR CHILDREN OF THE MARRIAGE. IN ORDER TO COMPLETE THE FOLLOWING QUESTIONS YOU MUST CALCULATE CHILD SUPPORT USING OUR DIVORCEEZ CHILD SUPPORT CALCULATOR. ACCORDING TO CURRENT FLORIDA LAW IF YOU HAVE MORE THAN ONE CHILD, CHILD SUPPORT IS REDUCED AS EACH CHILD REACHES THE AGE OF MAJORITY, GRADUATES FRM HIGH SCHOOL, BECOMES EMANCIPATED, MARRIED, DIES OR OTHERWISE BECOME SELF-SUPPORTING, BUT IN NO EVENT BEYOND THE AGE OF 19.</p>
        <p>Florida law requires child support to be automatically reduced when the obligation for support for a child terminates. That information is included in the final judgment.  If you have more than one child, you will need to calculate child support more than once. If you have 2 children, you will calculate twice; 3 children, 3 times, etc.</p>
        <p>AFTER you <strong><u>WATCH</u></strong> the DivorceEZ Child Support Video and use the DivorceEZ <strong><u>Child Support Calculator</u></strong>, please answer the following questions:</p></td>
</tr>
<tr>
    <td><label for="id_gu">Wife/Husband (hereinafter Obligator) will pay child suport, under Florida's child support guidelines, section 61.30 Florida Statues, to the other parent</label></td>
    <td>&nbsp;</td>
    <td><input type="radio" id="id_gu" name="field_gu" value="Wife" class="radio"/>Wife
        <input type="radio" id="id_gu" name="field_gu" value="Husband" class="radio"/>Husband
    </td>
</tr>
<tr>
    <td><label for="id_gv">Child Support in Amount</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_gw" name="field_gw" value="$"/></td>
</tr>
<tr>
    <td><label for="id_gw">Number of children (total number of parties' minor or dependent children)</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_gx" name="field_gx" value="Will Appear from Section G"/></td>
</tr>
<tr>
    <td><label for="id_gx">Commencing From</label></td>
    <td>&nbsp;</td>
    <td>
        <table border="0" cellspacing="0" cellpadding="0" class="dob">
            <tr>
                <td><label for="id_gy">Month</label></td>
                <td><select name="field_gy2" id="field_gy">
                    <option value="">Month</option>
                    <option value="1">Yes</option>
                </select></td>
                <td><label for="id_gz">Day</label></td>
                <td><select name="field_gz" id="id_gz">
                    <option value="">Day</option>
                    <option value="1">Yes</option>
                </select></td>
                <td><label for="id_ha">year</label></td>
                <td><select name="field_ha" id="id_ha">
                    <option value="">Year</option>
                    <option value="1">Yes</option>
                </select></td>
            </tr>
        </table></td>
</tr>
<tr>
    <td><label for="id_hb">Terminating At:</label></td>
    <td>&nbsp;</td>
    <td><table border="0" cellspacing="0" cellpadding="0" class="dob">
        <tr>
            <td><label for="id_gy">Month</label></td>
            <td><select name="field_gy2" id="field_gy">
                <option value="">Month</option>
                <option value="1">Yes</option>
            </select></td>
            <td><label for="id_gz">Day</label></td>
            <td><select name="field_gz" id="id_gz">
                <option value="">Day</option>
                <option value="1">Yes</option>
            </select></td>
            <td><label for="id_ha">year</label></td>
            <td><select name="field_ha" id="id_ha">
                <option value="">Year</option>
                <option value="1">Yes</option>
            </select></td>
        </tr>
    </table></td>
</tr>
<tr>
    <td><label for="id_hc">Upon the termination of the obligation of child support for one the parties' children, child support in the amount</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_hd" name="field_hd"/></td>
</tr>
<tr>
    <td><label for="id_hd">Number of children (total number of remaining children)</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_he" name="field_he"/></td>
</tr>
<tr>
    <td><label for="id_he">Commencing From</label></td>
    <td>&nbsp;</td>
    <td><table border="0" cellspacing="0" cellpadding="0" class="dob">
        <tr>
            <td><label for="id_gy">Month</label></td>
            <td><select name="field_gy2" id="field_gy">
                <option value="">Month</option>
                <option value="1">Yes</option>
            </select></td>
            <td><label for="id_gz">Day</label></td>
            <td><select name="field_gz" id="id_gz">
                <option value="">Day</option>
                <option value="1">Yes</option>
            </select></td>
            <td><label for="id_ha">year</label></td>
            <td><select name="field_ha" id="id_ha">
                <option value="">Year</option>
                <option value="1">Yes</option>
            </select></td>
        </tr>
    </table></td>
</tr>
<tr>
    <td><label for="id_hi">Terminating At:</label></td>
    <td>&nbsp;</td>
    <td><table border="0" cellspacing="0" cellpadding="0" class="dob">
        <tr>
            <td><label for="id_gy">Month</label></td>
            <td><select name="field_gy2" id="field_gy">
                <option value="">Month</option>
                <option value="1">Yes</option>
            </select></td>
            <td><label for="id_gz">Day</label></td>
            <td><select name="field_gz" id="id_gz">
                <option value="">Day</option>
                <option value="1">Yes</option>
            </select></td>
            <td><label for="id_ha">year</label></td>
            <td><select name="field_ha" id="id_ha">
                <option value="">Year</option>
                <option value="1">Yes</option>
            </select></td>
        </tr>
    </table></td>
</tr>
<tr>
    <td colspan="3"><h3>CHILD SUPPORT ARREARAGE</h3></td>
</tr>
<tr>
    <td><label for="id_hn">Is there currently is a child support arrearage</label></td>
    <td>&nbsp;</td>
    <td><input type="radio" id="id_hn" name="field_hn" value="1" class="radio"/>Yes
        <input type="radio" id="id_hn" name="field_hn" value="0" class="radio"/>No</td>
</tr>
<tr>
    <td><label for="id_ho">child Support Average Amount</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_hp" name="field_hp"/></td>
</tr>
<tr>
    <td><label for="id_hp">Amount (for previously ordered unpaid child support)</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_hq" name="field_hq"/></td>
</tr>
<tr>
    <td><label for="id_hq">The total amount in child support arrearage</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_hr" name="field_hr"/></td>
</tr>
<tr>
    <td><label for="id_hr">repaid at the rate of</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_hs" name="field_hs"/></td>
</tr>
<tr>
    <td><label for="id_hs">repaid at</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_ht" name="field_ht"/></td>
</tr>
<tr>
    <td><label for="id_ht">Commencing From</label></td>
    <td>&nbsp;</td>
    <td><table border="0" cellspacing="0" cellpadding="0" class="dob">
        <tr>
            <td><label for="id_gy">Month</label></td>
            <td><select name="field_gy2" id="field_gy">
                <option value="">Month</option>
                <option value="1">Yes</option>
            </select></td>
            <td><label for="id_gz">Day</label></td>
            <td><select name="field_gz" id="id_gz">
                <option value="">Day</option>
                <option value="1">Yes</option>
            </select></td>
            <td><label for="id_ha">year</label></td>
            <td><select name="field_ha" id="id_ha">
                <option value="">Year</option>
                <option value="1">Yes</option>
            </select></td>
        </tr>
    </table></td>
</tr>
<tr>
    <td><label for="id_hx">Terminating At:</label></td>
    <td>&nbsp;</td>
    <td><table border="0" cellspacing="0" cellpadding="0" class="dob">
        <tr>
            <td><label for="id_gy">Month</label></td>
            <td><select name="field_gy2" id="field_gy">
                <option value="">Month</option>
                <option value="1">Yes</option>
            </select></td>
            <td><label for="id_gz">Day</label></td>
            <td><select name="field_gz" id="id_gz">
                <option value="">Day</option>
                <option value="1">Yes</option>
            </select></td>
            <td><label for="id_ha">year</label></td>
            <td><select name="field_ha" id="id_ha">
                <option value="">Year</option>
                <option value="1">Yes</option>
            </select></td>
        </tr>
    </table></td>
</tr>
<tr>
    <td colspan="3"><h3><b>12.</b>OTHER CHILDREN (NOT AT THE MARRIAGE)</h3></td>
</tr>
<tr>
    <td><label for="id_ic">Did the wife give birth to any child(ren)</label></td>
    <td>&nbsp;</td>
    <td><input type="radio" id="id_ic" name="field_ic" value="1" class="radio"/>Yes
        <input type="radio" id="id_ic" name="field_ic" value="0" class="radio"/>No</td>
</tr>
<tr>
    <td><label for="id_id">if Yes, how many</label></td>
    <td>&nbsp;</td>
    <td><select name="field_id" id="id_id">
        <option value="">Choose</option>
        <option value="1">Yes</option>
    </select>
    </td>
</tr>
<tr>
    <td><label for="id_ie">Child No 1 Full Legal Name</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_if" name="field_if"/></td>
</tr>
<tr>
    <td><label for="id_if">Address</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_ig" name="field_ig"/></td>
</tr>
<tr>
    <td><label for="id_ig">Father Name</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_ih" name="field_ih"/></td>
</tr>
<tr>
    <td><label for="id_ih">Child No 2 Full Legal Name</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_ii" name="field_ii"/></td>
</tr>
<tr>
    <td><label for="id_ii">Address</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_ij" name="field_ij"/></td>
</tr>
<tr>
    <td><label for="id_ij">Father Name</label></td>
    <td>&nbsp;</td>
    <td><input type="text" class="text" id="id_ik" name="field_ik"/></td>
</tr>
ASSET;

	public function __construct()
	{
		//Constructor function
	}

	public function __get($var)
	{
		return $this->$var;
	}
}