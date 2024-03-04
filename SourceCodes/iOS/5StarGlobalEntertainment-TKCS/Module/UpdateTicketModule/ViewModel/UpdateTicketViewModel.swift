//
//  UpdateTicketViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 16/02/23.
//

import Foundation

class UpdateTicketViewModel : NSObject{
    // MARK: Variable Initializer--
    var updateCategoryData : UpdateTicketModel?
    var id = Int()
    var eventTitle = String()
    var price = Double()
    // MARK: Create function for call create ticket API-
    func callgetTicketApi(id: Int, complition: @escaping(UpdateTicketModel?, Bool)->Void){
        Webservice.service(api: .CreateTicket, urlAppendId: "/\(id)", service: .get) { (model: UpdateTicketModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    // MARK: Create function for call update ticket API-
    func callUpdateTicketApi(eventId: Int?, ticketTitle: String, ticketType: String,ticketQty: String, ticketPrice: String,endDate: String, endTime: String,  complition: @escaping(UpdateTicketModel?, Bool)->Void){
        let params: [String: Any] = [
            updateTicketParam.event_id : eventId ?? 0,
            updateTicketParam.ticket_title : ticketTitle,
            updateTicketParam.ticket_type: ticketType,
            updateTicketParam.total_qty : ticketQty,
            updateTicketParam.ticket_price : ticketPrice,
            updateTicketParam.end_date: endDate,
            updateTicketParam.end_time: endTime,
            "_method": "PUT"
            ]
        print("=========> ", params)
        Webservice.service(api: .CreateTicket, urlAppendId: "/\(id)",param: params, service: .post) { (model: UpdateTicketModel, data, json) in
            if model.statusCode == 200{
                self.updateCategoryData = model
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    
}
