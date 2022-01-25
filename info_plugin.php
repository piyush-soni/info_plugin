<?php
/*
Plugin Name: Info plugins
Plugin URI: http://example.com
Description: Plugin to list all plugins
Version: 1.0
Author: Piyush Soni
Author URI: http://piyush-soni.github.io
 */

function buildup()
{
	add_menu_page("Plugin Desc","Xplugins",'manage_options','xplug','html_code','dashicons-media-spreadsheet','4');
}

function html_code()
{
	if(array_key_exists('deactbtn',$_POST))
	{
		deactivate_plugins($_POST['id']);
	}
	if(array_key_exists('actbtn',$_POST))
	{
		activate_plugin($_POST['id']);
	}

	echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">';
	echo '<h1> PLUGINS </h1>';
	//include_once('wp-admin/includes/plugin.php');
	$arr = get_plugins();
	if(empty($arr))
	{
		return false;
	}
	echo '<table class="table table-striped table-dark">';
	echo '<thead class="thead-dark"><tr>';
	echo '<th scope="col"> # </th>';
	echo '<th scope="col"> Name </th>';
	echo '<th scope="col"> Status </th>';
	echo '<th scope="col"> Change </th>';
	echo '<th scope="col"> <center> Network Plugin? </center> </th>';
	echo '<th scope="col"> Slug Name </th>';
	echo '</tr></thead><tbody>';

	$n = 1;
	foreach($arr as $i=>$values)
	{
		echo '<tr>';
		echo '<th scope="row">'.$n++.'</th>';
		echo '<td>'.$values['Name'].'</td>';
		if(is_plugin_active(basename($i)))
		{
			echo '<td> Active  </td>';
		}
		else
		{
			echo '<td> Inactive </td>';
		}
		if(basename($i,'.php') == "info_plugin")
		{
			echo "<td> - </td>";
		}
		else
		{
			echo '<form method="post" action="">';
			echo '<input type="hidden" id="id" name="id" value="'.basename($i).'">';
			if(is_plugin_active(basename($i)))
			{
				echo '<td><input type="submit" class="btn btn-danger btn-sm" name="deactbtn" value="DEACTIVATE"></td>';
			}
			else
			{
				echo '<td><input type="submit" class="btn btn-success btn-sm" name="actbtn" value="ACTIVATE"></td>';
			}
			echo '</form>';
		}
		if(empty($values['Network']))
		{
			echo "<td> <center> &#10060; </center> </td>";
		}
		else
		{
			echo "<td> <center> &#10004; </center> </td>";
		}
		echo '<td>'.basename($i,'.php').'</td>';
		echo '</tr></th>';
	}
	echo '</tbody></table>';
}


add_action('admin_menu','buildup');
?>
