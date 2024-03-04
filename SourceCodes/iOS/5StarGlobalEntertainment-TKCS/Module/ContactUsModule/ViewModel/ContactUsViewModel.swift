//
//  ContactUsViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 06/01/23.
//

import Foundation
class ContactUsViewModel : NSObject{
    // MARK: Create function for call contactUs API--
    func callContactUsApi(name: String, email: String, phoneNum: String, query: String, complition: @escaping(ContactModel?, Bool)->Void){
        let param: [String: Any] = [
            ContactUsApiParam.name : name,
            ContactUsApiParam.email : email,
            ContactUsApiParam.phone_no : phoneNum,
            ContactUsApiParam.queries : name
        ]
        Webservice.service(api: .contactus, param: param,service: .post) { (model: ContactModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
}
