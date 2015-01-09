jQuery( document ).ready( function( $ ) {
	
	// Sort the items
	$( '.simmer-list-table tbody' ).sortable( {

		items:'> tr',
		cursor:'move',
		axis:'y',
		handle: '.simmer-sort-handle',
		placeholder: 'simmer-sort-placeholder',
		scrollSensitivity: 40,

		helper: function( e,ui ) {

			ui.children().each( function() {

				$( this ).width( $( this ).width() );

			} );

			return ui;
		},

		start: function( event, ui ) {

			ui.placeholder.html( '<td colspan="5"></td>' ).find( 'td' ).height( ui.item.find( 'td' ).height() );

		},

		stop: function( event, ui ) {
			
			var rows = $( ui.item ).parent().find( 'tr' ).not( '.simmer-row-hidden' );
			
			$( rows ).each( function( rowIndex ) {
				
		        $( this ).find( 'input, select, textarea' ).each( function() {
		        	
		        	var name = $( this ).attr( 'name' );
		        	
		        	name = name.replace( /\[(\d+)\]/, '[' + rowIndex+ ']');
		        	
		        	$( this ).attr( 'name', name ).attr( 'id', name );
		        	
		    	} );
		    	
		    } );

		}
	} );
	
	$( 'body' ).on( 'click', '.simmer-add-row', function( e ) {
		
		e.preventDefault();
		
		button = $( this );
		
		type = button.data( 'type' );
		
		row = button.parent().parent().parent().siblings( 'tbody' ).find( 'tr.simmer-' + type ).last();
		
		clone = row.clone();
		
		var count = row.parent().find( 'tr' ).length;
		
		clone.find( 'td input, td select, td textarea' ).not( '.simmer-heading-input' ).val( '' );
		
		clone.removeClass( 'simmer-row-hidden' );
		
		clone.find( 'input, select, textarea' ).each( function() {
			
			name = $( this ).attr( 'name' );

			name = name.replace( /\[(\d+)\]/, '[' + parseInt( count ) + ']');

			$( this ).attr( 'name', name ).attr( 'id', name );
			
		} );
		
		clone.insertAfter( row );
		
	} );
	
	$( 'body' ).on( 'click', '.simmer-remove-row', function( e ) {
		
		e.preventDefault();

		var row   = $( this ).parent().parent( 'tr' );
		
		var rows  = row.parent().find( 'tr' ).not( '.simmer-row-hidden' );
		
		var count = rows.not( '.simmer-heading' ).length;
		
		var type  = $( this ).data( 'type' );
		
		if ( count == 1 && 'heading' != type ) {
		
			switch( type ) {
				case 'ingredient' :
					alert( simmer_vars.remove_ingredient_min );
					break;
				case 'instruction' :
					alert( simmer_vars.remove_instruction_min );
					break;
			}
			
		} else {
			
			if ( '' == $( 'input, select, textarea', row ).val() ) {
				$( row ).remove();
			} else if ( window.confirm( simmer_vars.remove_ays ) ) {
				$( row ).remove();
			}
			
		}

		$( rows ).each( function( rowIndex ) {
			
	        $( this ).find( 'input, select, textarea' ).each( function() {
	        	
	        	var name = $( this ).attr( 'name' );
	        	
	        	name = name.replace( /\[(\d+)\]/, '[' + rowIndex+ ']');
	        	
	        	$( this ).attr( 'name', name ).attr( 'id', name );
	        	
	    	} );
	    	
	    } );
	    
	} );
	
} );