//
//  TokenServices.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/11/22.
//

import Foundation

import UIKit
class TokenService {
    static let sharedInstance = TokenService()
   
    let userDefault = UserDefaults.standard
   
    func saveToken(token: String, key : String){
        userDefault.set(token, forKey: key)
    }
   
    func getToken(key: String) -> String{
        if let token = userDefault.object(forKey: key) as? String{
            return token
        }else{
            return ""
        }
    }
    func checkLoginStatus() -> Bool{
        if getToken(key: Tokenkey.userLogin) == ""{
            return false
        }
        else{
            return true
        }
    }
    func removeUserDeafult(key : String){
        userDefault.removeObject(forKey: key)
    }
   
    func saveUserType(type: String,key : String){
        userDefault.set(type, forKey: key)
    }
   
    func getUserType(key: String) -> String{
        if let userType = userDefault.object(forKey: key) as? String{
            return userType
        }else{
            return ""
        }
    }
    func removeUserType(key: String){
        userDefault.removeObject(forKey: key)
        userDefault.synchronize()
    }
}
 
