//
//  UpdateUserViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 02/02/23.
//

import Foundation
class UpdateUserViewModel : NSObject{
    // MARK: Variable Initializer--
    var updateUserData : UpdateUserModel?
    var id = Int()
    // MARK: Create function for call get user API--
    func callGetUserApi(id: Int, complition: @escaping(UpdateUserModel?, Bool)->Void){
        
        Webservice.service(api: .GetUser, urlAppendId: "/\(id)", service: .get) { (model: UpdateUserModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    // MARK: Create function for update get user API--
    func callUpdateUserApi(id: Int, fName: String, lName: String, phoneNum: String, companyName: String, completion: @escaping(UpdateUserModel?, Bool)-> Void){
        let paramData : [String: Any] = [
            UpdateUserParam.first_name : fName,
            UpdateUserParam.last_name : lName,
            UpdateUserParam.phone_no : phoneNum,
            UpdateUserParam.company_name : companyName
        
        ]
        Webservice.service(api: .updateUser, urlAppendId: "/\(id)", param: paramData,service: .put) { (model: UpdateUserModel , data, json) in
            if model.statusCode == 200{
                self.updateUserData = model
                completion(model, true)
            }else{
                completion(model, false)
            }

        }
    }
        
    
}
