<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketviewTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("
                        CREATE VIEW ticketview AS
                        
                        SELECT 
                            t.id,
                            t.created_at AS 'date',
                            t.ticketname AS 'title',
                            t.details,
                            t.tickettype,
                            CONCAT('Item: ',i.propertynumber) AS 'tag' ,                      
                            CONCAT(u.firstname,' ',u.lastname) AS 'staffassigned',
                            t.staffassigned AS staff_id,
                            t.author,
                            t.status
                        FROM ticket AS t 
                            JOIN item_ticket AS it
                            ON it.ticket_id = t.id
                            JOIN itemprofile AS i
                            ON i.id = it.id
                            JOIN inventory AS inv
                            ON i.inventory_id = inv.id
                            JOIN itemtype AS itype
                            ON inv.itemtype_id = itype.id
                            JOIN user AS u
                            ON u.id =t.staffassigned
                            WHERE itype.name != 'System Unit'
                        
                        UNION
                        
                        SELECT 
                            t.id,
                            t.created_at AS 'date',
                            t.ticketname AS 'title',
                            t.details,
                            t.tickettype,
                            CONCAT('PC: ',ip.propertynumber) AS 'tag' ,                      
                            CONCAT(u.firstname,' ',u.lastname) AS 'staffassigned',
                            t.staffassigned AS staff_id,
                            t.author,
                            t.status
                        FROM ticket AS t 
                            JOIN pc_ticket AS pt
                            ON pt.ticket_id = t.id
                            JOIN pc AS p
                            ON p.id = pt.id  
                            JOIN itemprofile AS ip
                            ON ip.id = p.systemunit_id
                            JOIN user AS u
                            ON u.id =t.staffassigned 
                        
                        UNION

                        SELECT 
                            t.id,
                            t.created_at AS 'date',
                            t.ticketname AS 'title',
                            t.details,
                            t.tickettype,
                            CONCAT('Room: ',r.name) AS 'tag' ,                      
                            CONCAT(u.firstname,' ',u.lastname) AS 'staffassigned',
                            t.staffassigned AS staff_id,
                            t.author,
                            t.status
                        FROM ticket AS t 
                            JOIN room_ticket AS rt
                            ON rt.ticket_id = t.id
                            JOIN room AS r
                            ON r.id = rt.id
                            JOIN user AS u
                            ON u.id =t.staffassigned
                        
                        UNION

                        SELECT 
                            t.id,
                            t.created_at AS 'date',
                            t.ticketname AS 'title',
                            t.details,
                            t.tickettype,
                            ' ' AS 'tag' ,                      
                            CONCAT(u.firstname,' ',u.lastname) AS 'staffassigned',
                            t.staffassigned AS staff_id,
                            t.author,
                            t.status
                        FROM ticket AS t 
                            JOIN user AS u
                            ON u.id =t.staffassigned

                        UNION

                        SELECT 
                            t.id,
                            t.created_at AS 'date',
                            t.ticketname AS 'title',
                            t.details,
                            t.tickettype,
                            ' ' AS 'tag' ,                      
                            CONCAT(u.firstname,' ',u.lastname) AS 'staffassigned',
                            t.staffassigned AS staff_id,
                            t.author,
                            t.status
                        FROM ticket AS t 
                            JOIN ticket AS t2
                            ON t2.id =t.ticket_id
                            JOIN user AS u
                            ON u.id =t.staffassigned
                        UNION

                        SELECT 
                            t.id,
                            t.created_at AS 'date',
                            t.ticketname AS 'title',
                            t.details,
                            t.tickettype,
                            CONCAT('PC: ',ip.propertynumber) AS 'tag' ,                      
                            CONCAT(u.firstname,' ',u.lastname) AS 'staffassigned',
                            t.staffassigned AS staff_id,
                            t.author,
                            t.status
                        FROM ticket AS t 
                            JOIN ticket AS t2
                            ON t2.id =t.ticket_id 
                            JOIN pc_ticket AS pt
                            ON pt.ticket_id = t.id
                            JOIN pc AS p
                            ON p.id = pt.id  
                            JOIN itemprofile AS ip
                            ON ip.id = p.systemunit_id
                            JOIN user AS u
                            ON u.id =t.staffassigned 
                        
                        UNION

                        SELECT 
                            t.id,
                            t.created_at AS 'date',
                            t.ticketname AS 'title',
                            t.details,
                            t.tickettype,
                            CONCAT('Item: ',i.propertynumber) AS 'tag' ,                      
                            CONCAT(u.firstname,' ',u.lastname) AS 'staffassigned',
                            t.staffassigned AS staff_id,
                            t.author,
                            t.status
                        FROM ticket AS t 
                            JOIN ticket AS t2
                            ON t2.id =t.ticket_id
                            JOIN item_ticket AS it
                            ON it.ticket_id = t.id
                            JOIN itemprofile AS i
                            ON i.id = it.id
                            JOIN inventory AS inv
                            ON i.inventory_id = inv.id
                            JOIN itemtype AS itype
                            ON inv.itemtype_id = itype.id
                            JOIN user AS u
                            ON u.id =t.staffassigned
                            WHERE itype.name != 'System Unit'
                        
                        UNION

                        SELECT 
                            t.id,
                            t.created_at AS 'date',
                            t.ticketname AS 'title',
                            t.details,
                            t.tickettype,
                            CONCAT('Room: ',r.name) AS 'tag' ,                      
                            CONCAT(u.firstname,' ',u.lastname) AS 'staffassigned',
                            t.staffassigned AS staff_id,
                            t.author,
                            t.status
                        FROM ticket AS t 
                            JOIN ticket AS t2
                            ON t2.id =t.ticket_id
                            JOIN room_ticket AS rt
                            ON rt.ticket_id = t.id
                            JOIN room AS r
                            ON r.id = rt.id
                            JOIN user AS u
                            ON u.id =t.staffassigned
                            ;");
	}
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("DROP VIEW ticketview ");
	}

}
