//
//  ManagePromoterViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/01/23.
//

import Foundation

class ManagePromoterViewModel : Codable{
    // MARK: - Create function for call manage promoter API
    func callManagePromoterApi(completition: @escaping(ManagePromoterModel, Bool) -> Void) {
        Webservice.service(api: .ManagePromoter,service: .get) { (model: ManagePromoterModel , data, json) in
            if model.statusCode == 200 {
                completition(model,true)
            } else {
                completition(model,false)
            }
        }
    }
    // MARK: - Create function for call Delete promoter API
    func callDeletePromoterApi(id: Int, complition: @escaping(DeletePromoterModel?, Bool)->Void) {
        Webservice.service(api: .DeleteUser, urlAppendId:"/\(id)",service: .delete) { (model: DeletePromoterModel, data, json) in
            if model.statusCode == 200 {
                complition(model, true)
            } else {
                complition(model, false)
            }
        }
    }
    // MARK: - Create function for change Promoter Status
    func callChangePromoterStatus(userID: Int,status:Int, complition: @escaping(PromoterStatusModel?, Bool)->Void) {
        let urlAppendId = "/\(userID)/\(status)"
        Webservice.service(api: .makeOwnPromoter, urlAppendId: urlAppendId, service: .get) { (model: PromoterStatusModel, data, json) in
            if model.statusCode == 200 {
                complition(model, true)
            } else {
                complition(model, false)
            }
        }
    }
}
