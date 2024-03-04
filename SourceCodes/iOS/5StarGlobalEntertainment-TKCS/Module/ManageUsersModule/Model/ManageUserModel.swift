//
//  ManageUserModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 02/02/23.
//

import Foundation
struct ManageUserModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [ManageUserData]?
}

// MARK: - Datum
struct ManageUserData: Codable {
    var id, userType: Int?
    var firstName, lastName, email, phoneNo: String?
    var companyName: String?
    var emailVerifiedAt: String?
    var status: Int?
    var userProfile: String?
    var deletedAt: String?
    var createdAt, updatedAt: String?
    var isEmailVerified: Int?

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
// MARK: Create model for Delete user 
struct DeleteUserModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    
}
