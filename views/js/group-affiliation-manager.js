/* 
 * this is the js used by the Group Affiliation Manager
 */

var $ = jQuery,
    $add_collection_form,
    $existing_affiliation_collections;

jQuery(document).ready( function($) {
    $add_collection_form = $( "#add-collection-form" ).submit( save_collection );
});

function slideToggle(target){
    var $toggle = $(target + '-toggle');
    $(target).slideToggle("fast", function(){ 
        $toggle.text() === ">" ? $toggle.text("v") : $toggle.text(">")});
}

function save_collection(event){
    spinner = $( ".gam-spinner" ).css('display', 'inline-block');
    event.preventDefault();
    var nonce = $add_collection_form.find("input[name='nonce']").val(),
        action = $add_collection_form.find( "input[name='action']" ).val(),
        method = $add_collection_form.find( "input[name='method']" ).val(),
        group_id = $add_collection_form.find( "input[name='group_id']").val(),
        creator_id = $add_collection_form.find("input[name='creator_id']").val(),
        name = $add_collection_form.find( "input[name='name']").val(),
        description = $add_collection_form.find( "textarea[name='description']").val(),
        inheritable = $add_collection_form.find( "input[name='inheritable']").val(),
        form_data = { 
            nonce: nonce,
            action: action,
            method: method,
            group_id: group_id,
            creator_id: creator_id,
            name: name, 
            description: description,
            inheritable: inheritable
        };
    
    $.post( ajaxurl, form_data, function( data ) {
        slideToggle('#add-affiliation-collection');
        spinner.hide();
        
        var data = $.parseJSON(data);
        if (data['Error']){
            alert(data['Error'])
        } else {
            insert_collection(data);
        }
    });
    }
    
    /*
     * insert a collection into the page
     * data must be array with following keys
     * id, name, description, inheritable, creator_id, group_id, date_created
     */
    function insert_collection(collection){
                
        if (!$existing_affiliation_collections)
            $existing_affiliation_collections = $("#affiliation-collection-list");
               
        $existing_affiliation_collections
            .append( $("<li/>")
                .append( $("<h4/>")
                    .append( $("<span/>", {
                        "id":"affiliation-collection-" + collection['id'] + "-toggle",
                        "class":"affiliation-collection-toggle",
                        "text":">"}))
                    .append( $("<a/>", {
                        "href":"javascript:slideToggle('#affiliation-collection-" + collection['id'] + "');",
                        "text":collection['name']}))
                    .append( $("<span/>", {"class":"buttons"})
                            .append( $("<a/>", {"class":"button", "text":"add"}))
                            .append( $("<a/>", {"class":"button", "text":"edit"}))
                            .append( $("<a/>", {"class":"button", "text":"delete"}))))
                .append( $("<ul/>", {
                    "id":"affiliation-collection-" + collection['id'],
                    "class":"affiliation-collection",
                    "style":"display:none;"
                        })
                    .append( $("<li/>")
                        .append( $("<em/>", {"text":"empty collection"})))));
    }
    
    function delete_collection(collection_id, nonce){
        
        var $target = $("#affiliation-collection-" + collection_id);
        var $spinner = $("#spinner-collection-" + collection_id).show();
        var post_data = {
            "action":"affiliation_collection_controller_handle",
            "method":"delete",
            "nonce":nonce,
            "collection_id":collection_id
        }
        
        $.post( ajaxurl, post_data, function( data ) {
            $spinner.hide();

            var data = $.parseJSON(data);
            if (data['Error']){
                alert(data['Error'])
            } else {
                $target.css("background","yellow")
                        .slideUp()
                        .remove();
            }
        });        
        
    }

    