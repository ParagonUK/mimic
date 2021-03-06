<?php
require("header.php"); // Important includes

// Config
$AQUILON_URL = $CONFIG['URL']['AQUILON'];

// Gets node data and formats it
$jsondata = file_get_contents("$AQUILON_URL/cgi-bin/report/host_personality_branch");
if ($jsondata === false) {
    error("No data returned from", "aquilon");
}
$all_nodes = json_decode($jsondata, true);
uksort($all_nodes, "strnatcmp");

// Gets notes for nodes
$all_notes = Array();
$notes = mysql_query("select name, note from notes");
if ($notes and mysql_num_rows($notes)) {
    while ($note = mysql_fetch_assoc($notes)) {
        $all_notes[$note['name']] = $note['note'];
    }
}

// Generates main array
$results = Array();
foreach ($all_nodes as $name => $panels) {

    $archetype = $panels["archetype"];
    $group = "unknown";
    $panel = $panels["personality"];
    $cluster = '';

    if ($archetype === "rig") {
        $group = "rig";
    } elseif ($archetype === "rig_unmanaged") {
        $group = "rig_unmanaged";
    } elseif ($archetype === "isis") {
        $group = "isis";
    } elseif ($archetype === "ral-tier1") {
        $group = "ral-tier1";
    } elseif ($archetype === "ral-tier1-unmanaged") {
        $group = "ral-tier1-unmanaged";
    } elseif ($archetype === "ral-tier1-minimal") {
        $group = "ral-tier1-minimal";
    }
    $results[$group][$panel][$cluster][$name] = Array();
    if (array_key_exists($name, $all_nodes)) {
        $results[$group][$panel][$cluster][$name] = $all_nodes[$name];
    };
    if (array_key_exists($name, $all_notes)) {
        $results[$group][$panel][$cluster][$name]['note'] = $all_notes[$name];
    };
    if (nagios($name) !== Null) {
        $results[$group][$panel][$cluster][$name]['nagios'] = nagios($name);
    };
}

// Returns built json
echo json_encode($results);
