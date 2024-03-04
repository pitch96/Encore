//
//  Terms&ConditionViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/01/23.
//

import Foundation

class TermsConditionViewModel: NSObject{
    // MARK: Create function for call Terms & Condition API--
    func callTermsContionApi(completition: @escaping(TermsConditionModel, Bool) -> Void){
        Webservice.service(api: .TermsCondition,service: .get) { (model: TermsConditionModel , data, json) in
            if model.statusCode == 200{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
}
