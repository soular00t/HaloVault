<?php
$quotes[] = "\"<i>I'm going to spank myself a demon!</i>\"<br /><small>-Grunt, when spotting Spartan 117</small>";
$quotes[] = "\"<i><small>It's safe to come out, this is... Sergeant Humanoid. Uhh....Yeah</small></i>\"<br /><small>-Marine, when enemmy is hiding</small>";
$quotes[] = "\"<i>You're going down, big guy!</i>\"<br /><small>-Marine, attacking elite, brute, or hunter</small>";
$quotes[] = "\"<i>What will I do without him?</i>\"<br /><small>-Grunt, when he finds a dead ally</small>";
$quotes[] = "\"<i>I bet I can stick it!</i>\"<br /><small>-suicidal Grunt, when he charges at a player</small>";
$quotes[] = "\"<i>I thought I would never fight the demon!</i>\"<br /><small>-Grunt, when fighting Spartan 117</small>";
$quotes[] = "\"<i>Leader dead, FLEE!</i>\"<br /><small>-Grunt, when leader dies</small>";
$quotes[] = "\"<i>Stupid bully!</i>\"<br /><small>- Grunt, when spotting Spartan 117</small>";
$quotes[] = "\"<i>Someone help, I'm fighting Demon!</i>\"<br /><small>-Grunt, when fighting Spartan 117</small>";
$quotes[] = "\"<i><small>It's the Demon! He's going to tear off my arms and use them as Maracas!</small></i>\"<br /><small>-Grunt, when fighting Spartan 117</small>";
$quotes[] = "\"<i>Enjoy my bright. Blue. Balls!</i>\"<br /><small>-suicidal Grunt, when he charges at a player</small>";
$quotes[] = "\"<i>This is doom of biblical proportions!</i>\"<br /><small>-Marine, when you kill a lot of enemies</small>";
$quotes[] = "\"<i>Troopers! We are green, and very, very mean!</i>\"<br /><small>-Marine, Just before the drop on Easy and Normal.</small>";


srand ((double) microtime() * 1000000);
$random_number = rand(0,count($quotes)-1);

echo "<small>";
echo ($quotes[$random_number]);
echo "</small>";
?>