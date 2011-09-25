<?php require("include/header.php"); ?>
<!-- Page by Josh Snider -->
<section id="about">
Project Summary:<BR>


<p>Our project, OpenVote is allowed to allow communities to vote confidentially and without fraud while
 letting them see that their vote has been counted. Suppose the chair of the local Homeowner's Association
 wants to let the community vote about whether fences should be allowed. He goes to the OpenVote server
and types in the email addresses of each member of the community. Each member is assigned a 256-bit identifier
 which is sent to them in an email informing them of the vote. The particular voter is the only one who
 ever knows what their particular identifier is. Their user ID allows them to respond to the survey and
 upon submitting their encrypted vote the database disqualifies them from future voting. When all users
have taken the survey or a prespecified time has elapsed, the results are released with a list showing
every identifier and which option they selected.  Because no one can connect anyone else to a userid,
the voting results are completely confidential, but at the same time, completely transparent.</p>


<BR>

Powerpoint Walkthrough:
<BR>

<p>http://code4country.pbworks.com/w/file/46027223/OpenVote%20Presentation.odp</p>


<BR>

Code Link:
<BR>

https://github.com/gpittarelli/OpenVote<BR><BR>



Test Website:<BR>

http://openvote.gpittarelli.com/<BR><BR>




Group Members: <BR>
George Pittarelli - <a href="mailto:gjp@umd.edu">gjp@umd.edu</a><BR>
Kavin Arasu - <a href="mailto:karasu@gmu.edu">karasu@gmu.edu</a><BR>
Josh Snider - <a href="mailto:jsnider3@gmu.edu">jsnider3@gmu.edu</a><BR>
Scott DeHart - <a href="mailto:scottdehart@ast.comcqast.net">scottdehart@ast.comcqast.net</a><BR>
</section>
<?php require("include/footer.php"); ?>

