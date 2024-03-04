//
//  ManageTicketViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 14/02/23.
//

import Foundation

class ManageTicketViewModel : Codable{
    // MARK: Create function for call get ticket API--
    func callManageTicketApi(completition: @escaping(ManageTicketModel, Bool) -> Void){
        Webservice.service(api: .getTickets,service: .get) { (model: ManageTicketModel , data, json) in
            if model.statusCode == 200{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    // MARK: Create function for call delete ticket API--
    func callDeleteTicketApi(id: Int, complition: @escaping(DeleteTicketModel?, Bool)->Void){

        Webservice.service(api: .CreateTicket, urlAppendId:"/\(id)",service: .delete) { (model: DeleteTicketModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    // MARK: Create function for change ticket status API--
    func callGetTicketStatusApi(eventId: Int,status:Int, complition: @escaping(TicketStatusModel?, Bool)->Void){
        
        let st = "status"
    
        let urlAppendId = "/\(eventId)/\(st)/\(status)"
        
        Webservice.service(api: .CreateTicket, urlAppendId: urlAppendId, service: .get) { (model: TicketStatusModel, data, json) in
            
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    
}
