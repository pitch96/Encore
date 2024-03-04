////
////  TokenServices.swift
////  5StarGlobalEntertainment-TKCS
////
////  Created by chetu on 21/11/22.
////
//
import Foundation
class TokenService{
    static let tokenInstance = TokenService()
    let userDefault = UserDefaults.standard
    
    func saveToken(token: String,key : String){
        userDefault.set(token, forKey: key)
        UserDefaults.standard.synchronize()
    }
    func getToken(key : String)-> String{
        //userDefault.string(forKey: String)
        if let token = userDefault.object(forKey: key)as? String{
            return token
        }else{
            return ""
        }
        
    }
    
    func saveIsLogin(token: Bool){
        userDefault.set(token, forKey: TokenKey.userLogin)
        UserDefaults.standard.synchronize()
    }
    
    func getIsLogin()-> String{
        if let token = userDefault.object(forKey: TokenKey.userLogin) as? String{
            return token
        }else{
            return ""
        }
        
    }
    func removeToken(){
        userDefault.removeObject(forKey: TokenKey.userLogin)
        
    }
}
