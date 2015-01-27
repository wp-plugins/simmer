<?php

final class Simmer_Activation {
	
	public static function activate() {
		
		update_option( 'simmer_license', '' );
		
		$installed_version = get_option( 'simmer_version' );
		
		if ( version_compare( Simmer::VERSION, $installed_version, '>' ) ) {
			update_option( 'simmer_version', Simmer::VERSION );
		}
		
	}
	
	public static function deactivate() {
		
		delete_option( 'simmer_license' );
		
	}
	
}
