//
//  UserLogin.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/11/22.
//

import Foundation

struct UserLoginModel: Codable {
    let statusCode: Int?
    let success: Bool?
    let message: String?
    let data: UserLoginData?
    let token: String?
}

// MARK: - DataClass
struct UserLoginData: Codable {
    let id, userType: Int?
    let firstName, lastName, email, phoneNo: String?
    let companyName, emailVerifiedAt: JSONNull?
    let status: Int?
    let userProfile: String?
    let deletedAt: JSONNull?
    let createdAt, updatedAt: String?
    let isEmailVerified: Int?

    enum CodingKeys: String, CodingKey {
        case id
        case userType = "user_type"
        case firstName = "first_name"
        case lastName = "last_name"
        case email
        case phoneNo = "phone_no"
        case companyName = "company_name"
        case emailVerifiedAt = "email_verified_at"
        case status
        case userProfile = "user_profile"
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case isEmailVerified = "is_email_verified"
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
