//
//  UpdateEventChargeViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 28/04/23.
//

import Foundation

class UpdateEventChargeViewModel : Codable{
    // MARK: - Create function for call get subscriber user API
    func callEventChargeApi(completition: @escaping(EventChargeModel, Bool) -> Void){
        Webservice.service(api: .updateCharge,service: .get) { (model: EventChargeModel , data, json) in
            if model.statusCode == 200{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    func callUpdateEventChargeApi(id: Int?, charge: String?, complition: @escaping(UpdateEventChargeModel?, Bool)->Void){
        let params: [String: Any] = [
            "charge": charge ?? 0,
            "_method": "PUT"
            ]
        Webservice.service(api: .updateCharge, urlAppendId: "/\(id ?? 0)",param: params, service: .post) { (model: UpdateEventChargeModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    
    
}
