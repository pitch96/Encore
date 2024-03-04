//
//  UserLogin.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/11/22.
//

import Foundation

struct LoginModel: Codable{
    let success: Bool?
    let token: String?
    let message : String?
    
    enum CodingKeys: String, CodingKey {
        case success
        case token
        case message
        
    }
}
// MARK: logout model
struct LogoutModel: Codable{
    let success: Bool?
    let token: String?
    let status: String?
    let message: String?
    
    enum CodingKeys: String, CodingKey {
        case success
        case token
        case status
        case message
        
    }
}
