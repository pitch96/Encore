//
//  PromotionalViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 13/04/23.
//

import Foundation

class PromotionalViewModel: Codable{
    // MARK: Create function for get promotional list
    func callPromotionalListApi(complition: @escaping(PromotionalModel?, Bool)->Void){
        Webservice.service(api: .PromotionalList, service: .get) { (model: PromotionalModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    // MARK: - Create function for free Promotional list
    func callFreePromotionalListApi(complition: @escaping(FreeEventModelData?, Bool)->Void){
        Webservice.service(api: .FreePromotionList, service: .get) { (model: FreeEventModelData, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else {
                complition(model, false)
            }
        }
    }
    
    // MARK: - Create function for call change event status API
    func adminChangeEventStatusApi(action: Int, evntId:Int, complition: @escaping(StatusChangeModel?, Bool)->Void){
        let urlAppendId = "/\(action)/\(evntId)"
        Webservice.service(api: .AdminApprovalAction, urlAppendId: urlAppendId, service: .get) { (model: StatusChangeModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
}
