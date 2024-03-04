//
//  ManageUserViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 02/02/23.
//

import Foundation

class ManageUserViewModel : Codable{
    // MARK: Create function for call manage user API--
    func callManageUsersApi(completition: @escaping(ManageUserModel, Bool) -> Void){
        Webservice.service(api: .ManageUsers,service: .get) { (model: ManageUserModel , data, json) in
            if model.statusCode == 200{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    // MARK: Create function for call delete promoter API--
    func callDeleteUserApi(id: Int, complition: @escaping(DeleteUserModel?, Bool)->Void){

        Webservice.service(api: .DeleteUser, urlAppendId:"/\(id)",service: .delete) { (model: DeleteUserModel, data, json) in
            debugPrint(json)
            if model.statusCode == 200 {
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
}
