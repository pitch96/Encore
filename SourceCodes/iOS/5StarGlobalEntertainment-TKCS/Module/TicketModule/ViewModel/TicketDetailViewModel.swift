//
//  TicketDetailViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 22/03/23.
//

import Foundation

class TicketDetailViewModel : Codable{
    // MARK: - Variable initializer
    var id = Int()
    // MARK: Create view Model for Ticket Details API--
    func callTicketDetailApi(id: Int, complition: @escaping(TicketDetailModel, Bool)->Void){
        Webservice.service(api: .TicketDetail, urlAppendId: "/\(id)", service: .get) { (model: TicketDetailModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
}
