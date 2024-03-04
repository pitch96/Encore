//
//  ContactModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 06/01/23.
//

import Foundation
struct ContactModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: ContactData?
}

// MARK: - DataClass
struct ContactData: Codable {
    var name, email, phoneNo, queries: String?
    var updatedAt, createdAt: String?
    var id: Int?

    enum CodingKeys: String, CodingKey {
        case name, email
        case phoneNo = "phone_no"
        case queries
        case updatedAt = "updated_at"
        case createdAt = "created_at"
        case id
    }
}
