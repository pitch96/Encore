//
//  UpdateUserModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 02/02/23.
//

import Foundation
struct UpdateUserModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: UpdateUserDetail?
}

// MARK: - DataClass
struct UpdateUserDetail: Codable {
    var id, userType: Int?
    var firstName, lastName, email, phoneNo: String?
    var companyName, emailVerifiedAt: String?
    var status: Int?
    var userProfile, deletedAt: String?
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
