//
//  CreateTicketViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 15/02/23.
//

import Foundation
class CreateTicketViewModel : NSObject{
    // MARK: Create function for call Create Ticket API--
    func callCreateTicketApi(eventId: Int, ticketTitle: String, ticketType: String, totalQty: String, ticketPrice: String, endDate: String ,endTime: String, userId: Int, complition: @escaping (CreateTicketModel?, Bool)->Void){
        let param: [String: Any] = [
            
            CreateTicketParam.event_id : eventId,
            CreateTicketParam.ticket_title: ticketTitle,
            CreateTicketParam.ticket_type: ticketType,
            CreateTicketParam.total_qty: totalQty,
            CreateTicketParam.ticket_price: ticketPrice,
            CreateTicketParam.end_date:endDate,
            CreateTicketParam.end_time: endTime,
            CreateTicketParam.user_id: userId
        ]
        Webservice.service(api: .CreateTicket, param: param,service: .post) { (model: CreateTicketModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model,false)
            }
            
        }
        
    }
}
