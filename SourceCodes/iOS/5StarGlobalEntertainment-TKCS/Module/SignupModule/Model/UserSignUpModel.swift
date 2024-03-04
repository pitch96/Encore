//
//  UserSignUp.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/11/22.
//

import Foundation

// MARK: - Welcome
struct UserSignUpModel: Codable {
    let statusCode: Int?
    let success: Bool?
    let message: String?
    let data: UserSignUpData?
}

// MARK: - DataClass
struct UserSignUpData: Codable {
    let userType: String?
    let firstName, lastName, email: String?
    let phoneNo, companyName, updatedAt, createdAt: String?
    let id: Int?

    enum CodingKeys: String, CodingKey {
        case userType = "user_type"
        case firstName = "first_name"
        case lastName = "last_name"
        case email
        case phoneNo = "phone_no"
        case companyName = "company_name"
        case updatedAt = "updated_at"
        case createdAt = "created_at"
        case id
    }
}
