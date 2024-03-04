//
//  BookedEventDetailViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 23/03/23.
//

import Foundation

class BookedEventDetailViewModel : Codable{
    // MARK: Variable initializer--
    var id = Int()
    var image = String()
    // MARK: Create view Model for Ticket Details API--
    func callBookedEventDetailApi(id: Int, complition: @escaping(BookedEventDetailModel, Bool)->Void){
        Webservice.service(api: .TotalTicket, urlAppendId: "/\(id)", service: .get) { (model: BookedEventDetailModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
}
