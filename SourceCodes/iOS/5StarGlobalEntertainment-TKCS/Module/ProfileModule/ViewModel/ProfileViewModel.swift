//
//  ProfileViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 14/12/22.
//

import Foundation
import UIKit

class ProfileViewModel{
    // MARK: Variable Initializer--
    var profileData : ProfileModel?
    var media : [Media] = []
    // MARK: Create function For call Profile API--
    func CallProfileApi(completition: @escaping(ProfileModel, Bool) -> Void){
        Webservice.service(api: .account,service: .get) { (model: ProfileModel , data, json) in
            if model.success ?? false{
                self.profileData = model
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    // MARK: Create function For call Update Profile API--
    func CallProfileUpdateApi(fName: String, lName: String,phoneNum: String, companyName: String, userProfile: String, file: [Media],  completition: @escaping(ProfileModel, Bool) -> Void){
        let paramData : [String: Any] = [
            ProfileApiParam.first_name : fName,
            ProfileApiParam.last_name : lName,
            ProfileApiParam.phone_no : phoneNum,
            ProfileApiParam.company_name : companyName
        ]
        Webservice.service(api: .updateProfile,param: paramData,service: .post, file: file) { (model: ProfileModel , data, json) in
            if model.success ?? false{
                self.profileData = model
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    
}
