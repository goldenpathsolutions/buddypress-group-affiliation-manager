<?php

/* 
 * This view allows user to view/update affiliations when creating a group
 */

//first, populate what we have so far of the current group....

// retrieve $current_group's id
global $group_affiliation_manager;
$current_group = $group_affiliation_manager->view_parameters['current_group'];
$affiliations_collection_controller_url = 
        $GPS_GAM_DIR . '/controllers/affiliations_collection_controller.php';

$nonce = wp_create_nonce( 'gps_gam_nonce');
?>
</form> <!-- we're using ajax, so kill the parent form. -->
<div class="container_100">
    
    
<!-- ****************************************************************** -->
<!-- This Group's Affiliations -->

<div id="group-affiliation-collections" class="container_45">
    <div id="existing-affiliation-collections">
        <h3>Affiliation Collections for <em><?= $current_group->get_name() ?></em><a id="add-collection-button" class="button" href="javascript:slideToggle('#add-affiliation-collection');">Add Collection...</a></h3>
    
        <div id="add-affiliation-collection" style="display:none;"><a class="close" href="javascript:slideToggle('#add-affiliation-collection');">X</a>
        <form action="/wp-admin/admin-ajax.php" id="add-collection-form" method='post'>
            <input type="hidden" name="nonce" value="<?=$nonce?>">
            <input type="hidden" name='action' value='affiliation_collection_controller_handle'/>
            <input type="hidden" name='method' value='add'/>
            <input type="hidden" name='group_id' value='<?= $current_group->get_id() ?>'>
            <input type='hidden' name='creator_id' value='<?=get_current_user_id()?>'>
            <ul>
                <li><label>Name</label><input name="name" type="text"/></li>
                <li><label>Description</label><textarea id="gac_description" name="description" rows="1"></textarea></li>
                <li class="checkbox"><input type="checkbox" name="inheritable"/><label>May be Inherited</label><a class="info" title="When checked, subgroups of this group may also use this collection.">?</a></li>
                <li class="gam-submit-button"><input type="submit" title="Save Affiliation Collection" value="Save"/><span class="gam-spinner">&nbsp;</span></li>
            </ul>
        </form>
    </div>
        
        <ul id='affiliation-collection-list'>
    
<?php

    $collections = $current_group->get_affiliation_collections();
    if (empty($collections)){
        echo "<p><em>*** This group doesn't own any collections. ***</em></p>";
    } else {

        foreach ( $collections as $collection ){
            $affiliations = $collection->get_affiliations();

            echo "<li id='affiliation-collection-" . $collection->get_id() . "'><h4>
                    <span id='affiliation-collection-" . $collection->get_id() . "-toggle' class='affiliation-collection-toggle'>></span>
                    <a href=\"javascript:slideToggle('#affiliation-collection-" . $collection->get_id() . "');\">" . $collection->get_name() . "</a>
                    <span class='buttons'>
                        <a class='button'>add</a>
                        <a class='button'>edit</a>
                        <a href=\"javascript:delete_collection(" . $collection->get_id() . ", ". $nonce .")\" class='button'>delete</a>
            </span><span id=\"spinner-collection-" . $collection->get_id() . "\" class=\"gam-spinner\">&nbsp;</span></h4>";

            if ($collection->get_description())
                echo "<p class='description'>" . $collection->get_description() . "</p>";

            echo "<ul id='affiliation-collection-" . $collection->get_id() . "' class='affiliation-collection' style='display:none;'>";
            if ( !empty ( $affiliations ) ){

                    foreach ( $affiliations as $affiliation ){

                        echo "<li>" . $affiliation->get_name();
                            echo "<a href=''>edit</a>  <a href=''>delete</a>";
                        echo "</li>";
                    }
            } else {
                echo "<li><em>empty collection</em></li>";
            }
            echo "</ul>";

            echo"</li>";
        } //foreach
    } //if no collections

?>
            
        </ul>  <!-- #affiliation-collection-list -->
    </div> <!-- #existing-affiliation-collections -->
    
    
</div> <!-- #group-affiliation-collections -->


<!-- ****************************************************************** -->
<!-- Inherited Affiliations -->

<?php


//if current group has ancestors, list all of the inherited Group Affiliations
if ( !is_null( $current_group->get_parent() ) ){
?> 

<div id="group-ancestor-affiliations" class="container_45">
    <h3>Inherited Affiliations for <em><?= $current_group->get_name() ?></em></h3>
    <p>Following are all affiliations that this group inherits from its <a title='Ancestors are groups that contain this group'>ancestors</a>.</p>
    
    <ul>

    <?php
    $parent = $current_group->get_parent();
    $found_inherited_affiliations = false;
    while ( !is_null( $parent ) ) {
        
        $collections = $parent->get_affiliation_collections();
        foreach ( $collections as $collection){
            
            if ( $collection->is_inheritable() ){
                $found_inherited_affiliations = true;

                
                echo "<li><h4>" .  $collection->get_name() . "( " . $parent->get_name() . " )</h4><ul>";
                
                foreach ( $collection->get_affiliations() as $affiliation ){
                    
                    echo "<li>" . $collection->get_name() . "</li>";
                    
                }
                
                echo "</ul></li>";
            
                
            }
            
        }
    ?>
        
        
        
    <?php
        
        $parent = $parent->get_parent();
    
    } //END Foreach Ancestor
    
    
    if (!$found_inherited_affiliations){
        echo "<li><em>*** This group doesn't inherit any collections. ***</em></li>";
    }
    ?>
    </ul>
</DIV>


<?php


} //END Has Ancestors

?>


</div> <!-- .Container_100 -->


