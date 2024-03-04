//
//  TokenServices.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/11/22.
//

import Foundation

import UIKit
// MARK: - Token Class
class TokenService {
    static let sharedInstance = TokenService()
    let userDefault = UserDefaults.standard
    func saveToken(token: String, key : String){
        userDefault.set(token, forKey: key)
    }
    // MARK: - Create function for get Token
    func getToken(key: String) -> String{
        if let token = userDefault.string(forKey: key){
            return token
        }else{
            return ""
        }
    }
    // MARK: - Create function for check login Status
    func checkLoginStatus() -> Bool{
        if getToken(key: Tokenkey.userLogin) == ""{
            return false
        }
        else{
            return true
        }
    }
    // MARK: - Create function for remove User-Dafault
    func removeUserDeafult(key : String){
        userDefault.removeObject(forKey: key)
    }
    // MARK: - Create function for save User-Type
    func saveUserType(type: String,key : String){
        userDefault.set(type, forKey: key)
    }
    // MARK: - Create function for check User-login
    func getUserLogin(bool: Bool,key : String){
        userDefault.set(bool, forKey: key)
    }
    // MARK: - Create function for get login
    func getLogin()->Bool{
        return userDefault.bool(forKey: KeysDefaults.isLogin)
    }
    func getUserType(key: String) -> String{
        if let userType = userDefault.object(forKey: key) as? String{
            return userType
        }else{
            return ""
        }
    }
    // MARK: - Create function for remove User-type
    func removeUserType(key: String){
        userDefault.removeObject(forKey: key)
        userDefault.synchronize()
    }
}
// MARK: - create enum for keyDefault
    enum KeysDefaults{
        static let token = "token"
        static let isLogin = "isLogin"
    }
    
