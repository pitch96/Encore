//
//  PrivacyPolicyViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/01/23.
//

import Foundation


class PrivacyPolicyViewModel: NSObject{
    // MARK: Create function for call privacy Policy API--
    func callPrivacyPolicyApi(completition: @escaping(PrivacyPolicyModel, Bool) -> Void){
        Webservice.service(api: .PrivacyPolicy,service: .get) { (model: PrivacyPolicyModel , data, json) in
            if model.statusCode == 200{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
}
