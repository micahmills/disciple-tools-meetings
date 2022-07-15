<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class Disciple_Tools_Meetings_Tile
{
    private static $_instance = null;
    public static function instance(){
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct(){
        add_filter( 'dt_details_additional_tiles', [ $this, "dt_details_additional_tiles" ], 10, 2 );
        add_filter( "dt_custom_fields_settings", [ $this, "dt_custom_fields" ], 20, 2 );
        add_action( "dt_details_additional_section", [ $this, "dt_add_section" ], 10, 2 );
        add_action( "dt_details_additional_section", [ $this, "dt_add_meeting_submit" ], 21, 2 );
    }

    /**
     * This function registers a new tile to a specific post type
     *
     * @todo Set the post-type to the target post-type (i.e. contacts, groups, trainings, etc.)
     * @todo Change the tile key and tile label
     *
     * @param $tiles
     * @param string $post_type
     * @return mixed
     */
    public function dt_details_additional_tiles( $tiles, $post_type = "" ) {
        if ( $post_type === "groups" || $post_type === "meetings"){
            $tiles["disciple_tools_meetings"] = [ "label" => __( "Meetings", 'disciple-tools-meetings' ) ];
        }
        return $tiles;
    }

    /**
     * @param array $fields
     * @param string $post_type
     * @return array
     */
    public function dt_custom_fields( array $fields, string $post_type = "" ) {
        /**
         * @todo set the post type
         */
        // if ( $post_type === "groups" || $post_type === "meetings" ){
        //     /**
        //      * @todo Add the fields that you want to include in your tile.
        //      *
        //      * Examples for creating the $fields array
        //      * Contacts
        //      * @link https://github.com/DiscipleTools/disciple-tools-theme/blob/256c9d8510998e77694a824accb75522c9b6ed06/dt-contacts/base-setup.php#L108
        //      *
        //      * Groups
        //      * @link https://github.com/DiscipleTools/disciple-tools-theme/blob/256c9d8510998e77694a824accb75522c9b6ed06/dt-groups/base-setup.php#L83
        //      */

        //     /**
        //      * This is an example of a text field
        //      */
        //     // $fields['disciple_tools_meetings_attendees'] = [
        //     //     "name" => __( 'Meeting Attendee List', 'disciple_tools' ),
        //     //     'description' => _x( 'The members who are attended this meeting.', 'Optional Documentation', 'disciple-tools-meetings' ),
        //     //     "type" => "connection",
        //     //     "post_type" => "contacts",
        //     //     "p2p_direction" => "to",
        //     //     "p2p_key" => "contacts_to_meeting",
        //     //     "icon" => get_template_directory_uri() . '/dt-assets/images/list.svg?v=2',
        //     // ];
        //     /**
        //      * This is an example of a multiselect field
        //      */
        //     // $fields["disciple_tools_meetings_multiselect"] = [
        //     //     "name" => __( 'Multiselect', 'disciple-tools-meetings' ),
        //     //     "default" => [
        //     //         "one" => [ "label" => __( "One", 'disciple-tools-meetings' ) ],
        //     //         "two" => [ "label" => __( "Two", 'disciple-tools-meetings' ) ],
        //     //         "three" => [ "label" => __( "Three", 'disciple-tools-meetings' ) ],
        //     //         "four" => [ "label" => __( "Four", 'disciple-tools-meetings' ) ],
        //     //     ],
        //     //     "tile" => "disciple_tools_meetings",
        //     //     "type" => "multi_select",
        //     //     "hidden" => false,
        //     //     'icon' => get_template_directory_uri() . '/dt-assets/images/edit.svg',
        //     // ];
        //     /**
        //      * This is an example of a key select field
        //      */
        //     // $fields["disciple_tools_meetings_keyselect"] = [
        //     //     'name' => "Key Select",
        //     //     'type' => 'key_select',
        //     //     "tile" => "disciple_tools_meetings",
        //     //     'default' => [
        //     //         'first'   => [
        //     //             "label" => _x( 'First', 'Key Select Label', 'disciple-tools-meetings' ),
        //     //             "description" => _x( "First Key Description", "Training Status field description", 'disciple-tools-meetings' ),
        //     //             'color' => "#ff9800"
        //     //         ],
        //     //         'second'   => [
        //     //             "label" => _x( 'Second', 'Key Select Label', 'disciple-tools-meetings' ),
        //     //             "description" => _x( "Second Key Description", "Training Status field description", 'disciple-tools-meetings' ),
        //     //             'color' => "#4CAF50"
        //     //         ],
        //     //         'third'   => [
        //     //             "label" => _x( 'Third', 'Key Select Label', 'disciple-tools-meetings' ),
        //     //             "description" => _x( "Third Key Description", "Training Status field description", 'disciple-tools-meetings' ),
        //     //             'color' => "#366184"
        //     //         ],
        //     //     ],
        //     //     'icon' => get_template_directory_uri() . '/dt-assets/images/edit.svg',
        //     //     "default_color" => "#366184",
        //     //     "select_cannot_be_empty" => true
        //     // ];
        // }
        return $fields;
    }

    public function dt_add_section( $section, $post_type ) {
        /**
         * @todo set the post type and the section key that you created in the dt_details_additional_tiles() function
         */
        if ( $section === "disciple_tools_meetings" ){
            /**
             * These are two sets of key data:
             * $this_post is the details for this specific post
             * $post_type_fields is the list of the default fields for the post type
             *
             * You can pull any query data into this section and display it.
             */
            $this_post = DT_Posts::get_post( $post_type, get_the_ID() );
            $post_type_fields = DT_Posts::get_post_settings( "meetings" );

            ?>

            <!--
            @todo you can add HTML content to this section.
            -->



            <div class="reveal" id="create-meeting-modal" data-reveal data-reset-on-close>
            <h3 class="section-header">Create A Meetings</h3>
                <div class="cell small-12 medium-4">
                    <div class="members-section" style="margin-bottom:10px">
                    <div class="attendee-checklist">
                    </div>
                </div>
                </div>

                <div class="section-subheader">Meeting Date</div>
                <div class="disciple_tools_meeting_date input-group">
                    <input id="disciple_tools_meeting_date" class="input-group-field dt_date_picker" type="text" autocomplete="off" value="">
                    <div class="input-group-button">
                        <button id="disciple_tools_meeting_date-clear-button" class="button alert clear-date-button" data-inputid="disciple_tools_meeting_date" title="Delete Date" type="button">x</button>
                    </div>
                </div>

                <div class="section-subheader">Meeting Topic</div>
                <input id="disciple_tools_meeting_topic" type="text" class="" value="">

                <div class="section-subheader">Meeting Notes</div>
                <textarea id="disciple_tools_meeting_notes" class="textarea"></textarea>

                <div class="section-subheader">Meeting Type</div>
                <select class="" id="disciple_tools_meeting_type" style="">
                    <option value="default">Default</option> <!-- NEEDS RENDERED SERVER SIDE -->
                    <option value="default2">Default2</option> <!-- NEEDS RENDERED SERVER SIDE -->

                </select>

                <button id="disciple_tools_add_meetings-button" class="button"><?php esc_html_e( 'Add A Meeting', 'disciple-tools-meetings' ) ?></button>
            </div>

        <?php }
    }

    public function dt_add_meeting_submit( $section, $post_type ) {
        if ( $section === "disciple_tools_meetings" && $post_type !== "meetings" ){
        /**
         * These are two sets of key data:
         * $this_post is the details for this specific post
         * $post_type_fields is the list of the default fields for the post type
         *
         * You can pull any query data into this section and display it.
         */
            $this_post = DT_Posts::get_post( $post_type, get_the_ID() );
            $post_type_fields = DT_Posts::get_post_field_settings( $post_type );
            $post_type_label = DT_Posts::get_post_settings( get_post_type() ?: "contacts" )['label_singular'];
        /**
         * @todo set the post type and the section key that you created in the dt_details_additional_tiles() function
         */?>
          <? render_field_for_display( 'meetings', $post_type_fields, $this_post, true ); ?>

          <button id="disciple_tools_create_meetings-button" class="button"><?php esc_html_e( 'Create A Meeting', 'disciple-tools-meetings' ) ?></button>
            <!-- </div> -->
<style>
    .groups-template-default #disciple_tools_meetings-tile .section-body .date, .groups-template-default #disciple_tools_meetings-tile .section-body #meetings_topic, .groups-template-default #disciple_tools_meetings-tile .section-body #meeting_notes, .groups-template-default #disciple_tools_meetings-tile .section-body .select-field, .groups-template-default #disciple_tools_meetings-tile .section-body #contact_connection, .groups-template-default #disciple_tools_meetings-tile .section-body #contacts_connection, #disciple_tools_meetings-tile .section-body .section-subheader {
        display: none;
    }
</style>
            <script>
                //Initialize Date Picker so it doesn't update the current post.
                function date_picker_init(is_bulk = false, bulk_id = 0) {
                    // Determine field class name to be used.
                    let field_class = (!is_bulk) ? `.dt_date_picker` : `.dt_date_picker-${bulk_id}`;

                    // Assign on click listener.
                    $(field_class).datepicker({
                    constrainInput: false,
                    dateFormat: 'yy-mm-dd',
                    onClose: function (date) {
                        date = window.SHAREDFUNCTIONS.convertArabicToEnglishNumbers(date);
                        if (!$(this).val()) {
                        date = " ";//null;
                        }
                        let id = $(this).attr('id')
                        // new_post[id] = date
                        if (this.value) {
                        this.value = window.SHAREDFUNCTIONS.formatDate(moment.utc(date).unix());
                        }

                        // If bulk related, capture epoch
                        if (is_bulk) {
                        $(this).data('selected-date-epoch', moment.utc(date).unix());
                        }
                    },
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "1900:2050",
                    });
                }

                date_picker_init();


                /* Create attendees CheckList */
                let post = window.detailsSettings.post_fields;
                let attendeeChecklist = document.querySelector('.attendee-checklist');
                let populateattendeeCheckList = ()=>{
                    //empty attendeesChecklist
                    while(attendeeChecklist.firstChild)
                        attendeeChecklist.removeChild(attendeeChecklist.firstChild);

                        post.members.forEach(attendee=>{
                            let attendeeChecklistHTML = `<div class="member-row" style="" data-id="${window.lodash.escape( attendee.ID )}">
                                <input style="margin: 0.25em .5em 0 0" type="checkbox" name="attendeeChecklist-ID" class="attendeeCheckbox" value="${window.lodash.escape( attendee.ID )}">
                                <div style="flex-grow: 1" class="attendee-status">
                                    <span>${window.lodash.escape(attendee.post_title)}</span>
                                </div>`
                                attendeeChecklist.insertAdjacentHTML('beforeend', attendeeChecklistHTML)
                        })
                }

                populateattendeeCheckList();

                //Open Meeting Creation Modal
                let createMeetingButton = document.querySelector("#disciple_tools_create_meetings-button");

                createMeetingButton.addEventListener('click', event => {
                    $('#create-meeting-modal').foundation('open');
                })


                //Get Fields to create Meeting Post
                meetingFields = {
                    "date": "",
                    "assigned_to": <?php echo esc_html( get_current_user_id() ); ?>,
                    "contacts": {
                        "values": []
                    },
                    "groups": {
                        "values": [
                            {
                                "value": <?php echo get_the_ID(); ?>
                            }
                        ]
                    },
                    "type": "",
                    "name": "",
                    "meetings_topic": "",
                }

                var addMeetingButton = document.querySelector("#disciple_tools_add_meetings-button");

                addMeetingButton.addEventListener('click', event => {
                    meetingFields.name = document.querySelector("#disciple_tools_meeting_topic").value;
                    meetingFields.date = document.querySelector("#disciple_tools_meeting_date").value;
                    meetingFields.type = document.querySelector("#disciple_tools_meeting_type").value;
                    meetingFields.meeting_notes = document.querySelector("#disciple_tools_meeting_notes").value;
                    meetingFields.meetings_topic = document.querySelector("#disciple_tools_meeting_topic").value;

                    //gets all attendees checkboxes, filters for those that are checked, addes the ID value to an array to be used in the meetingFields Object.
                    let attendeesArray = [...document.querySelectorAll('.member-row input')].filter(row => { return row.checked }).map(attendees => { return {"value" : attendees.value}});

                    meetingFields.contacts.values = attendeesArray;

                    window.API.create_post('meetings', meetingFields).then((newMeeting)=>{
                        //close modal
                        $('#create-meeting-modal').foundation('close');
                        //clear inputs
                        document.querySelector("#disciple_tools_meeting_topic").value = "";
                        document.querySelector("#disciple_tools_meeting_date").value = "";
                       document.querySelector("#disciple_tools_meeting_type").value = "";
                        document.querySelector("#disciple_tools_meeting_notes").value = "";
                        document.querySelectorAll('.attendeeCheckbox').forEach((attendee) => { attendee.checked = false; })

                    });
                });
            </script>
            <?php }
    }
}
Disciple_Tools_Meetings_Tile::instance();
