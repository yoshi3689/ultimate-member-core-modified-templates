<?php
add_filter("um_user_display_name_filter","display_nickname_if_available", 10, 2);

function display_nickname_if_available( $name, $profile_id ){
   
   um_fetch_user( $profile_id );
   $nickname = get_user_meta( $profile_id, 'nickname', true );

   if ( !empty( $nickname ) ) {
       $name = $nickname;
   } else {
       $name = um_user("first_name");
   }

   return $name;
}